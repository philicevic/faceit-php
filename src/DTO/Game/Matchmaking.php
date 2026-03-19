<?php

namespace Philicevic\FaceitPhp\DTO\Game;

class Matchmaking
{
    public function __construct(
        public readonly string $uuid,
        public readonly string $name,
        public readonly string $game,
        public readonly string $region,
        public readonly bool $hasLeague,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            uuid: $data['id'],
            name: (string) ($data['name'] ?? ''),
            game: (string) ($data['game'] ?? ''),
            region: (string) ($data['region'] ?? ''),
            hasLeague: (bool) ($data['has_league'] ?? false),
        );
    }
}
