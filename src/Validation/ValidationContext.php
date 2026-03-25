<?php

namespace Philicevic\FaceitPhp\Validation;

class ValidationContext
{
    private static bool $strict = false;

    /** @var array<string> */
    private static array $pathStack = [];

    public static function enable(): void
    {
        self::$strict = true;
    }

    public static function disable(): void
    {
        self::$strict = false;
        self::$pathStack = [];
    }

    public static function isStrict(): bool
    {
        return self::$strict;
    }

    public static function pushPath(string $segment): void
    {
        self::$pathStack[] = $segment;
    }

    public static function popPath(): void
    {
        array_pop(self::$pathStack);
    }

    public static function currentPath(): string
    {
        return implode('.', self::$pathStack);
    }
}
