<?php

namespace App\Prkt;

use App\Prkt\exceptions\MaxSizeException;
use App\Prkt\exceptions\WrongMimeTypeException;
use Symfony\Component\Yaml\Yaml;

class Searcher
{
    public $path;
    public $configPath;
    public $config;

    public function __construct($path, $configPath = null)
    {
        $this->path = $path;
        $this->configPath = __DIR__ . '/config.yaml';

        if ($configPath !== null) {
            $this->config = $this->parseConfig();
        }
    }

    public function getOccurrence($string)
    {
        if ($this->config !== null && !empty($this->validateConfig())) {
            return implode(", ", $this->validateConfig());
        }

        if (empty($string)) {
            return null;
        }

        $data = $this->getContent();

        $map = [
            '1' => 'strpos',
            '0' => 'stripos'
        ];

        $result = [];
        foreach ($data as $i => $row) {
            $entry = $map[$this->config['case-insensitive']]($row, $string);
            if ($entry !== false) {
                $result['row'] = $i + 1;
                $result['position'] = $entry + 1;
            }
        }

        if (!empty($result)) {
            return "Row: {$result['row']}, position: {$result['position']}";
        }
        
        return 'Occurrences not found';
    }

    public function getContent()
    {
        $handle = fopen($this->path, "r");
        $data = [];
        if ($handle) {
            while (($line = fgets($handle)) !== false) {
                $data[] = $line;
            }
        }

        return $data;
    }

    public function parseConfig()
    {
        if ($this->configPath) {
            $config = Yaml::parse(file_get_contents($this->configPath));
        }

        return $config;
    }

    public function validateConfig()
    {

        if ($this->config['mime_type'] !== mime_content_type($this->path)) {
            throw new WrongMimeTypeException();
        }

        $measureUnit = substr(mb_strtolower($this->config['max_size']), -1);

        switch ($measureUnit) {
            case 'b':
                $maxSize = preg_replace("/[^0-9]/", '', $this->config['max_size']);
                break;
            case 'k':
                $maxSize = preg_replace("/[^0-9]/", '', $this->config['max_size']) * 1024;
                break;
            case 'm':
                $maxSize = preg_replace("/[^0-9]/", '', $this->config['max_size']) * 1048576;
                break;
            case 'g':
                $maxSize = preg_replace("/[^0-9]/", '', $this->config['max_size']) * 1073741824;
                break;
        }

        if ($maxSize < filesize($this->path)) {
            throw new MaxSizeException();
        }
    }
}
