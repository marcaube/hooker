<?php

namespace Ob\Hooker\Command;

use Ob\Hooker\Hook\HookInterface;
use Symfony\Component\Console\Command\Command;

class BaseCommand extends Command
{
    /**
     * @var array
     */
    protected $config;

    /**
     * @var array
     */
    protected $hooks = array();

    /**
     * @param array $config
     */
    public function __construct(array $config)
    {
        parent::__construct();
        $this->config = $config;

        foreach ($config['hooks'] as $class) {
            $hook = new $class($config);

            if (is_subclass_of($hook, '\Ob\Hooker\Hook\HookInterface')) {
                $this->addHook($hook);
            }
        }
    }

    /**
     * @param HookInterface $hook
     */
    private function addHook(HookInterface $hook)
    {
        $this->hooks[] = $hook;
    }
}
