<?php

namespace Philicevic\FaceitPhp\DTO\Search;

readonly class Game
{
    public function __construct(
        public string $name,
        public string $skillLevel,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            name: $data['name'],
            skillLevel: (string) ($data['skill_level'] ?? ''),
        );
    }
}
