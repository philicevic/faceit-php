<?php

namespace Philicevic\FaceitPhp\DTO\Match\Stats;

use Philicevic\FaceitPhp\DTO\Player\StatsPlayer;

readonly class Team
{
    /**
     * @param  array<string, mixed>  $stats
     * @param  array<StatsPlayer>  $players
     */
    public function __construct(
        public string $uuid,
        public bool $premade,
        public array $stats,
        public array $players,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            uuid: (string) ($data['team_id'] ?? ''),
            premade: (bool) ($data['premade'] ?? false),
            stats: $data['team_stats'] ?? [],
            players: array_map(fn (array $p): StatsPlayer => StatsPlayer::fromArray($p), $data['players'] ?? []),
        );
    }
}
