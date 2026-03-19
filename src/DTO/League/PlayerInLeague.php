<?php

namespace Philicevic\FaceitPhp\DTO\League;

class PlayerInLeague
{
    public function __construct(
        public readonly string $divisionName,
        public readonly string $divisionTier,
        public readonly string $divisionType,
        public readonly string $leaderboardId,
        public readonly int $points,
        public readonly int $position,
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
