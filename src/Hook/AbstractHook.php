<?php

namespace Ob\Hooker\Hook;

abstract class AbstractHook implements HookInterface
{
    protected $config;

    /**
     * {@inheritdoc}
     */
    public function __construct(array $config)
    {
        $this->config = $config;
    }
}
