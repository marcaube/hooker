<?php

namespace Ob\Hooker\Hook\PreCommit;

use Ob\Hooker\Hook\AbstractHook;

/**
 * Run phpcs on a file
 */
class CodeSniffer extends AbstractHook
{
    /**
     * @param string $file
     *
     * @return int Exit status code
     */
    public function execute($file)
    {
        $standard = $this->config['phpcs']['standard'] ? : 'PSR2';

        exec("./vendor/bin/phpcs --standard=$standard $file", $stdout, $failed);

        if (!is_array($stdout)) {
            return 0;
        }

        if (count($stdout) > 5) {
            foreach ($stdout as $warning) {
                echo $warning . PHP_EOL;
            }
            $failed = true;
        }

        return (int) !$failed;
    }
}
