<?php

namespace Philicevic\FaceitPhp\DTO\Search;

use Philicevic\FaceitPhp\Validation\ValidatesFields;

readonly class Game
{
    use ValidatesFields;

    public function __construct(
        public string $name,
        public string $skillLevel,
    ) {}

    protected static function fieldSchema(): array
    {
        return [
            'name' => 'string',
            'skill_level' => '?string',
        ];
    }

    public static function fromArray(array $data): self
    {
        return static::validated($data, fn ($d) => new self(
            name: $d['name'],
            skillLevel: (string) ($d['skill_level'] ?? ''),
        ));
    }
}
