<?php

namespace App\Models\Exceptions;

class UnknownErrorException extends AppException
{
    protected $message = "Unknown error";
}
