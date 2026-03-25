<?php

namespace Philicevic\FaceitPhp\DTO\Championship\Results;

use Philicevic\FaceitPhp\Validation\ValidatesFields;

class Bounds
{
    use ValidatesFields;

    public function __construct(
        public int $left,
        public int $right,
    ) {}

    public static function fromArray(array $data): self
    {
        return static::validated($data, fn ($d) => new self(
            left: $d['left'],
            right: $d['right'],
        ));
    }

    protected static function fieldSchema(): array
    {
        return [
            'left' => 'int',
            'right' => 'int',
        ];
    }
}
