<?php

namespace App\Prkt;

use Symfony\Component\Yaml\Yaml;

class Config
{
    public $configPath;

    public function __construct($configPath)
    {
        $this->configPath = $configPath;
    }

    public function parseConfig()
    {
        if ($this->configPath) {
            $config = Yaml::parse(file_get_contents($this->configPath));
        }

        return $config;
    }
}
