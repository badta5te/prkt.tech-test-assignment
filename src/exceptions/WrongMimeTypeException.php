<?php

namespace App\Prkt\exceptions;

use Exception;

class WrongMimeTypeException extends Exception
{
    protected $message = 'Mime type does not support';
}
