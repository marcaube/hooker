<?php

namespace Ob\Hooker\Hook\PreCommit;

use Ob\Hooker\Hook\AbstractHook;

/**
 * Run php lint on a file
 */
class Lint extends AbstractHook
{
    /**
     * @param string $file
     *
     * @return int Exit status code
     */
    public function execute($file)
    {
        exec("/usr/bin/php -l $file 2> /dev/null", $stdout, $failed);

        if ($failed) {
            echo $stdout[0] . PHP_EOL;
        }

        return (int) !$failed;
    }
}
