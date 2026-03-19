<?php

namespace Philicevic\FaceitPhp\DTO\Leaderboard;

class Leaderboard
{
    public function __construct(
        public readonly string $leaderboardId,
        public readonly string $leaderboardName,
        public readonly string $leaderboardType,
        public readonly string $leaderboardMode,
        public readonly string $competitionId,
        public readonly string $competitionType,
        public readonly string $gameId,
        public readonly string $region,
        public readonly string $status,
        public readonly string $pointsType,
        public readonly string $rankingType,
        public readonly int $group,
        public readonly int $round,
        public readonly int $season,
        public readonly int $startDate,
        public readonly int $endDate,
        public readonly int $minMatches,
        public readonly int $pointsPerWin,
        public readonly int $pointsPerLoss,
        public readonly int $pointsPerDraw,
        public readonly int $startingPoints,
        public readonly int $rankingBoost,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            leaderboardId: $data['leaderboard_id'],
            leaderboardName: (string) ($data['leaderboard_name'] ?? ''),
            leaderboardType: (string) ($data['leaderboard_type'] ?? ''),
            leaderboardMode: (string) ($data['leaderboard_mode'] ?? ''),
            competitionId: (string) ($data['competition_id'] ?? ''),
            competitionType: (string) ($data['competition_type'] ?? ''),
            gameId: (string) ($data['game_id'] ?? ''),
            region: (string) ($data['region'] ?? ''),
            status: (string) ($data['status'] ?? ''),
            pointsType: (string) ($data['points_type'] ?? ''),
            rankingType: (string) ($data['ranking_type'] ?? ''),
            group: (int) ($data['group'] ?? 0),
            round: (int) ($data['round'] ?? 0),
            season: (int) ($data['season'] ?? 0),
            startDate: (int) ($data['start_date'] ?? 0),
            endDate: (int) ($data['end_date'] ?? 0),
            minMatches: (int) ($data['min_matches'] ?? 0),
            pointsPerWin: (int) ($data['points_per_win'] ?? 0),
            pointsPerLoss: (int) ($data['points_per_loss'] ?? 0),
            pointsPerDraw: (int) ($data['points_per_draw'] ?? 0),
            startingPoints: (int) ($data['starting_points'] ?? 0),
            rankingBoost: (int) ($data['ranking_boost'] ?? 0),
        );
    }
}
