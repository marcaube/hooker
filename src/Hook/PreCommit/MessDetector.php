<?php

namespace Ob\Hooker\Hook\PreCommit;

use Ob\Hooker\Hook\AbstractHook;

/**
 * Run phpmd on a file
 */
class MessDetector extends AbstractHook
{
    /**
     * @param string $file
     *
     * @return int Exit status code
     */
    public function execute($file)
    {
        $defaultRulesets = array('cleancode', 'codesize', 'controversial', 'design', 'naming', 'unusedcode');

        $rulesets = $this->config['phpmd']['rulesets'] ? : $defaultRulesets;
        $rulesets = implode(',', $rulesets);

        exec("./vendor/bin/phpmd $file text $rulesets", $stdout, $failed);

        if (!is_array($stdout)) {
            return 0;
        }

        foreach ($stdout as $warning) {
            if (!empty($warning)) {
                $failed = true;
                echo $warning . PHP_EOL;
            }
        }

        return (int) !$failed;
    }
}
