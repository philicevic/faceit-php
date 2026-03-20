<?php

namespace Philicevic\FaceitPhp\DTO\Match\Stats;

readonly class Team
{
    /**
     * @param  array<string, mixed>  $stats
     * @param  array<Player>  $players
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
            uuid: $data['team_id'],
            premade: (bool) $data['premade'],
            stats: $data['team_stats'],
            players: array_map(Player::fromArray(...), $data['players']),
        );
    }
}
