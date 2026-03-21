<?php

namespace Philicevic\FaceitPhp\Validation;

use Philicevic\FaceitPhp\Exceptions\MissingFieldException;
use Philicevic\FaceitPhp\Exceptions\TypeMismatchException;
use Philicevic\FaceitPhp\Exceptions\UnknownFieldException;

trait ValidatesFields
{
    /** @return array<string, string> */
    abstract protected static function fieldSchema(): array;

    protected static function validated(array $data, \Closure $factory): mixed
    {
        $name = substr(static::class, strrpos(static::class, '\\') + 1);
        ValidationContext::pushPath($name);
        try {
            static::validateData($data);

            return $factory($data);
        } finally {
            ValidationContext::popPath();
        }
    }

    protected static function validateData(array $data): void
    {
        if (! ValidationContext::isStrict()) {
            return;
        }

        $schema = static::fieldSchema();
        $dtoClass = static::class;
        $path = ValidationContext::currentPath();

        foreach ($schema as $field => $type) {
            $optional = str_starts_with($type, '?');
            $baseType = $optional ? substr($type, 1) : $type;

            if (! array_key_exists($field, $data)) {
                if (! $optional) {
                    throw new MissingFieldException($dtoClass, $field, $path);
                }

                continue;
            }

            $value = $data[$field];

            if ($value === null) {
                if (! $optional) {
                    throw new TypeMismatchException($dtoClass, $field, $baseType, 'null', $path);
                }

                continue;
            }

            $valid = match ($baseType) {
                'string' => is_string($value),
                'int' => is_int($value),
                'float' => is_float($value) || is_int($value),
                'bool' => is_bool($value),
                'array' => is_array($value),
                default => true,
            };

            if (! $valid) {
                throw new TypeMismatchException($dtoClass, $field, $baseType, get_debug_type($value), $path);
            }
        }

        $knownFields = array_keys($schema);
        foreach (array_keys($data) as $field) {
            if (! in_array($field, $knownFields, true)) {
                throw new UnknownFieldException($dtoClass, (string) $field, $path);
            }
        }
    }
}
