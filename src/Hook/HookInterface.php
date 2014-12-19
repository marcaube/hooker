<?php

namespace Ob\Hooker\Hook;

interface HookInterface
{
    /**
     * @param array $config
     * @return void
     */
    public function __construct(array $config);

    /**
     * @param mixed $arg
     *
     * @return int Exit status code
     */
    public function execute($arg);
}
