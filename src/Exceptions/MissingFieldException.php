<?php

namespace Philicevic\FaceitPhp\Exceptions;

class MissingFieldException extends ValidationException
{
    public function __construct(string $dtoClass, string $field, string $path = '')
    {
        $location = $path ? "{$path}.{$field}" : $field;

        parent::__construct(
            dtoClass: $dtoClass,
            violations: ["Missing required field: {$location}"],
            message: "[{$dtoClass}] Missing required field: {$location}",
        );
    }
}
