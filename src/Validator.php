<?php

namespace App\Prkt;

use App\Prkt\exceptions\MaxSizeException;
use App\Prkt\exceptions\WrongMimeTypeException;

class Validator
{
    public function validateConfig($filePath, $configPath)
    {
        if ($configPath['mime_type'] !== mime_content_type($filePath)) {
            throw new WrongMimeTypeException();
        }

        $measureUnit = substr(mb_strtolower($configPath['max_size']), -1);

        switch ($measureUnit) {
            case 'b':
                $maxSize = preg_replace("/[^0-9]/", '', $configPath['max_size']);
                break;
            case 'k':
                $maxSize = preg_replace("/[^0-9]/", '', $configPath['max_size']) * 1024;
                break;
            case 'm':
                $maxSize = preg_replace("/[^0-9]/", '', $configPath['max_size']) * 1048576;
                break;
            case 'g':
                $maxSize = preg_replace("/[^0-9]/", '', $configPath['max_size']) * 1073741824;
                break;
        }

        if ($maxSize < filesize($filePath)) {
            throw new MaxSizeException();
        }

        return true;
    }
}
