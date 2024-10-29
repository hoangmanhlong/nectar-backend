<?php

namespace App\Models;

use Exception;

abstract class Result
{
    public static function success($data): Success
    {
        return new Success($data);
    }

    public static function error(Exception $exception): Error
    {
        return new Error($exception);
    }
}

class Success extends Result
{
    public $data;

    public function __construct($data)
    {
        $this->data = $data;
    }
}

class Error extends Result
{
    public $exception;

    public function __construct(Exception $exception)
    {
        $this->exception = $exception;
    }
}
