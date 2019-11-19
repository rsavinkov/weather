<?php

namespace rsavinkov\Weather\DTO\Error;

class ErrorResponse
{
    public $success = false;

    public $errors;

    public function __construct(Error ...$errors)
    {
        $this->errors = $errors;
    }

    public function addError($propertyPath, $message): self
    {
        $this->errors[] = new Error($propertyPath, $message);

        return $this;
    }

    public function hasErrors(): bool
    {
        return !empty($this->errors);
    }
}
