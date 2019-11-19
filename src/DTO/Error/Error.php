<?php

namespace rsavinkov\Weather\DTO\Error;

class Error
{
    public $propertyPath;

    public $message;

    public function __construct(string $propertyPath, string $message)
    {
        $this->propertyPath = $propertyPath;
        $this->message = $message;
    }
}
