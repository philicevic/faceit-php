<?php

namespace Philicevic\FaceitPhp\Exceptions;

class ValidationException extends FaceitException
{
    public function __construct(
        public readonly string $dtoClass,
        public readonly array $violations,
        string $message = '',
    ) {
        parent::__construct($message ?: implode('; ', $violations));
    }
}
