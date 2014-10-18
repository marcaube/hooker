<?php

namespace Ob\Hooker\Hook;

interface HookInterface
{
    /**
     * @param array $config
     */
    public function __construct(array $config);

    /**
     * @param mixed $arg
     *
     * @return int Exit status code
     */
    public function execute($arg);
}
