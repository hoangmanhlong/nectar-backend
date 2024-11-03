<?php

namespace App\Models\Exceptions;

class EmailOrPasswordIncorrectException extends AppException
{
    protected $message = "Email or password incorrect";
}
