<?php

namespace Philicevic\FaceitPhp\DTO\Player;

readonly class LifetimeStats
{
    /**
     * @param  array<string, mixed>  $lifetime
     * @param  array<array<string, mixed>>  $segments
     */
    public function __construct(
        public string $playerId,
        public string $gameId,
        public array $lifetime,
        public array $segments,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            playerId: $data['player_id'],
            gameId: $data['game_id'],
            lifetime: $data['lifetime'] ?? [],
            segments: $data['segments'] ?? [],
        );
    }
}
