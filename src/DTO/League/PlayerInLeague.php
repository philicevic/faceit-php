<?php

namespace Philicevic\FaceitPhp\DTO\League;

readonly class PlayerInLeague
{
    public function __construct(
        public string $divisionName,
        public string $divisionTier,
        public string $divisionType,
        public string $leaderboardId,
        public int $points,
        public int $position,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            divisionName: (string) ($data['division_name'] ?? ''),
            divisionTier: (string) ($data['division_tier'] ?? ''),
            divisionType: (string) ($data['division_type'] ?? ''),
            leaderboardId: (string) ($data['leaderboard_id'] ?? ''),
            points: (int) ($data['points'] ?? 0),
            position: (int) ($data['position'] ?? 0),
        );
    }
}
