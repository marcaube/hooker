#!/usr/bin/php
<?php

// Get all added|copied|modified files (i.e. ACM)
exec('git diff --cached --name-status --diff-filter=ACM | grep \\\\.php', $output);
$failed = false;

foreach ($output as $line) {
    $action = trim($line[0]);
    $file = trim(substr($line, 1));

    $failed = lint($file);
    $failed = messDetector($file);
    $failed = codeSniffer($file);
}

// Prevent commit if there was a failure
if ($failed) {
    echo "\nCommit aborted, please fix violations first." . PHP_EOL;
    exit(1);
}

/**
 * @param string $file
 *
 * @return bool hasFailed
 */
function lint($file)
{
    exec("/usr/bin/php -l $file 2> /dev/null", $output, $failed);

    if ($failed) {
        echo $output[0] . PHP_EOL;
    }

    return (bool) $failed;
}

/**
 * @param string $file
 *
 * @return bool hasFailed
 */
function messDetector($file)
{
    // Available rulesets: cleancode, codesize, controversial, design, naming, unusedcode.
    exec("./vendor/bin/phpmd $file text cleancode,codesize,controversial,design,naming,unusedcode", $output, $failed);

    foreach ($output as $warning)
    {
        if (!empty($warning)) {
            $failed = true;
            echo $warning . PHP_EOL;
        }
    }

    return (bool) $failed;
}

/**
 * @param string $file
 *
 * @return bool hasFailed
 */
function codeSniffer($file)
{
    exec("./vendor/bin/phpcs --standard=PSR2 $file", $output, $failed);

    if (count($output) > 5) {
        foreach ($output as $warning) {
            echo $warning . PHP_EOL;
        }
        $failed = true;
    }

    return (bool) $failed;
}
