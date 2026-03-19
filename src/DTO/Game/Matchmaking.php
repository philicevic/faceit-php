<?php

namespace Philicevic\FaceitPhp\DTO\Game;

readonly class Matchmaking
{
    public function __construct(
        public string $uuid,
        public string $name,
        public string $game,
        public string $region,
        public bool $hasLeague,
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
