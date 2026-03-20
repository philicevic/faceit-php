<?php

namespace Philicevic\FaceitPhp\Exceptions;

class TypeMismatchException extends ValidationException
{
    public function __construct(
        string $dtoClass,
        string $field,
        string $expectedType,
        string $actualType,
        string $path = '',
    ) {
        $location = $path ? "{$path}.{$field}" : $field;

        parent::__construct(
            dtoClass: $dtoClass,
            violations: ["Field '{$location}' expected {$expectedType}, got {$actualType}"],
            message: "[{$dtoClass}] Field '{$location}' expected {$expectedType}, got {$actualType}",
        );
    }
}
