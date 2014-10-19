<?php

namespace Ob\Hooker\Console\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class PreCommitCommand extends BaseCommand
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

        if (!is_array($stdout)) {
            return;
        }

        $failed = false;

        foreach ($stdout as $line) {
            $file = trim(substr($line, 1));

            /** @var HookInterface $hook */
            foreach ($this->hooks as $hook) {
                $code = $hook->execute($file);

                $failed = $failed || $code === 0;
            }
        }

        // Prevent commit if there was a failure
        if ($failed && $this->config['abort_on_fail']) {
            $output->writeln("\n<error>Commit aborted, please fix violations first.</error>");

            return 1;
        }
    }
}
