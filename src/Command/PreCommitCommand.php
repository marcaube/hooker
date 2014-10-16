<?php

namespace Ob\Hooker\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class PreCommitCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('hook:pre-commit')
            ->setDescription('Execute pre-commit hooks')
        ;
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // Get all added|copied|modified files (i.e. ACM)
        exec('git diff --cached --name-status --diff-filter=ACM | grep \\\\.php', $stdout);

        foreach ($stdout as $line) {
            $action = trim($line[0]);
            $file = trim(substr($line, 1));

            $failed = $this->lint($file);
            $failed = $this->messDetector($file);
            $failed = $this->codeSniffer($file);
        }

        // Prevent commit if there was a failure
        if ($failed) {
            echo "\nCommit aborted, please fix violations first." . PHP_EOL;
            exit(1);
        }
    }

    /**
     * @param string $file
     *
     * @return bool hasFailed
     */
    private function lint($file)
    {
        exec("/usr/bin/php -l $file 2> /dev/null", $stdout, $failed);

        if ($failed) {
            echo $stdout[0] . PHP_EOL;
        }

        return (bool) $failed;
    }

    /**
     * @param string $file
     *
     * @return bool hasFailed
     */
    private function messDetector($file)
    {
        // Available rulesets: cleancode, codesize, controversial, design, naming, unusedcode.
        exec(
            "./vendor/bin/phpmd $file text cleancode,codesize,controversial,design,naming,unusedcode",
            $stdout,
            $failed
        );

        foreach ($stdout as $warning) {
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
    private function codeSniffer($file)
    {
        exec("./vendor/bin/phpcs --standard=PSR2 $file", $stdout, $failed);

        if (count($stdout) > 5) {
            foreach ($stdout as $warning) {
                echo $warning . PHP_EOL;
            }
            $failed = true;
        }

        return (bool) $failed;
    }
}
