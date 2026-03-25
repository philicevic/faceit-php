<?php

namespace Philicevic\FaceitPhp\DTO\Search;

use Philicevic\FaceitPhp\Validation\ValidatesFields;

readonly class PlayerGame
{
    use ValidatesFields;

    public function __construct(
        public string $name,
        public int $skillLevel,
    ) {}

    protected static function fieldSchema(): array
    {
        return [
            'name' => 'string',
            'skill_level' => 'int',
        ];
    }

    public static function fromArray(array $data): self
    {
        return static::validated($data, fn ($d) => new self(
            name: $d['name'],
            skillLevel: (int) ($d['skill_level'] ?? 0),
        ));
    }
}
