<?php

namespace App\Models\Exceptions;

class AccountAlreadyExistsException extends AppException
{
    protected $message = "Account already exists";
}
