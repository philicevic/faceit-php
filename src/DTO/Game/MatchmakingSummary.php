<?php

namespace Philicevic\FaceitPhp\DTO\Game;

readonly class MatchmakingSummary
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
            uuid: (string) ($data['matchmaking_id'] ?? ''),
            name: (string) ($data['name'] ?? ''),
            game: (string) ($data['game'] ?? ''),
            region: (string) ($data['region'] ?? ''),
            hasLeague: (bool) ($data['has_league'] ?? false),
        );
    }
}
