<?php

namespace App\Prkt\exceptions;

use Exception;

class MaxSizeException extends Exception
{
    protected $message = 'File too large';
}
