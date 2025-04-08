<?php

namespace App\Exceptions;

class ProductNotFoundException extends BaseHttpException
{
    public function __construct(string $message = 'Product not found')
    {
        parent::__construct($message, 404);
    }
}