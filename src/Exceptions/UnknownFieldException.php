<?php

namespace Philicevic\FaceitPhp\Exceptions;

class UnknownFieldException extends ValidationException
{
    public function __construct(string $dtoClass, string $field, string $path = '')
    {
        $location = $path ? "{$path}.{$field}" : $field;

        parent::__construct(
            dtoClass: $dtoClass,
            violations: ["Unknown field: {$location}"],
            message: "[{$dtoClass}] Unknown field: {$location}",
        );
    }
}
