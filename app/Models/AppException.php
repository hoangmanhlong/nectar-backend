<?php

namespace App\Models;
use Exception;

class EmailOrPasswordIncorrectException extends Exception {
    protected $message = "Email or password incorrect";
}
