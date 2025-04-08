<?php

namespace App\Exceptions;

use Exception;

class InvalidDtoArguments extends Exception
{
    private array $errors;

    public function __construct(?array $errors = null, string $message = 'Bad request')
    {
        $this->errors = $errors;
        parent::__construct($message,400);
    }

    public function getErrors(): array
    {
        return $this->errors;
    }
}