<?php

namespace App\Shared\Response;

class ConstraintViolation
{
    public function __construct(
        public readonly string $property,
        public readonly string $value,
        public readonly string $message,
    ) {
    }
}
