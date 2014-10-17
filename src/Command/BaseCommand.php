<?php

namespace Ob\Hooker\Command;

use Symfony\Component\Console\Command\Command;

abstract class BaseCommand extends Command
{
    protected $config;

    public function setConfig(array $config)
    {
        $this->config = $config;
    }
}