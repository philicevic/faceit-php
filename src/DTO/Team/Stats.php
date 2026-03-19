<?php

namespace Philicevic\FaceitPhp\DTO\Team;

class Stats
{
    /**
     * @param  array<string, mixed>  $lifetime
     * @param  array<array<string, mixed>>  $segments
     */
    public function __construct(
        public readonly string $teamId,
        public readonly string $gameId,
        public readonly array $lifetime,
        public readonly array $segments,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            teamId: $data['team_id'],
            gameId: $data['game_id'],
            lifetime: $data['lifetime'] ?? [],
            segments: $data['segments'] ?? [],
        );
    }
}
