<?php

namespace Philicevic\FaceitPhp\DTO\Leaderboard;

readonly class Leaderboard
{
    public function __construct(
        public string $leaderboardId,
        public string $leaderboardName,
        public string $leaderboardType,
        public string $leaderboardMode,
        public string $competitionId,
        public string $competitionType,
        public string $gameId,
        public string $region,
        public string $status,
        public string $pointsType,
        public string $rankingType,
        public int $group,
        public int $round,
        public int $season,
        public int $startDate,
        public int $endDate,
        public int $minMatches,
        public int $pointsPerWin,
        public int $pointsPerLoss,
        public int $pointsPerDraw,
        public int $startingPoints,
        public int $rankingBoost,
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
