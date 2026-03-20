<?php

namespace Philicevic\FaceitPhp\DTO\Hub;

readonly class HubStats
{
    /**
     * @param  array<HubStatsPlayer>  $players
     */
    public function __construct(
        public string $gameId,
        public array $players,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            gameId: (string) ($data['game_id'] ?? ''),
            players: array_map(HubStatsPlayer::fromArray(...), $data['players'] ?? []),
        );
    }
}
