<?php

namespace Ob\Hooker\Console;

use Symfony\Component\Console\Application as BaseApplication;
use Symfony\Component\Yaml\Yaml;

class Application extends BaseApplication
{
    /**
     * @var array
     */
    private $config;

    public function __construct()
    {
        parent::__construct('Hooker', '1.0.x-dev');

        $this->parseConfig();
    }

    /**
     * Return the application config
     *
     * @return array
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * Parse application config
     */
    private function parseConfig()
    {
        $parser = new Yaml();

        $configFiles = array(
            __DIR__ . '/../../../../../hooker.yml',
            __DIR__ . '/../../../../../hooker.yml.dist',
            __DIR__ . '/../../hooker.yml',
            __DIR__ . '/../../hooker.yml.dist'
        );

        foreach ($configFiles as $file) {
            if (file_exists($file)) {
                $this->config = $parser->parse($file);
                break;
            }
        }
    }
}
