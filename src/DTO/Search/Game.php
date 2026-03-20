<?php

namespace Philicevic\FaceitPhp\DTO\Search;

use Philicevic\FaceitPhp\Validation\ValidatesFields;
use Philicevic\FaceitPhp\Validation\ValidationContext;

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
        ValidationContext::pushPath('SearchGame');
        try {
            static::validateData($data);

            return new self(
                name: $data['name'],
                skillLevel: (string) ($data['skill_level'] ?? ''),
            );
        } finally {
            ValidationContext::popPath();
        }
    }
}
