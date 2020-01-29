<?php

namespace App\Prkt;

use App\Prkt\Config;
use App\Prkt\Validator;

class Searcher
{
    public $path;
    public $configPath;
    public $config;

    public function __construct($path, $configPath = null)
    {
        $this->path = $path;

        //не уверен, что код ниже должен быть в конструкторе
        if ($this->configPath === null) {
            $this->config['max_size'] = '1g';
            $this->config['mime_type'] = 'text/plain';
            $this->config['case-insensitive'] = false;
        }

        $config = new Config($configPath);
        $this->config = $config->parseConfig();
    }

    public function getOccurrence($string)
    {
        if (empty($string)) {
            return null;
        }

        $validator = new Validator();
        $validator->validateConfig($this->path, $this->config);

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
}
