<?php

namespace Philicevic\FaceitPhp\DTO\Leaderboard;

use Philicevic\FaceitPhp\Validation\ValidatesFields;
use Philicevic\FaceitPhp\Validation\ValidationContext;

readonly class Leaderboard
{
    use ValidatesFields;

    public function __construct(
        public string $uuid,
        public string $competitionId,
        public string $competitionType,
        public string $gameId,
        public string $region,
        public string $leaderboardMode,
        public string $leaderboardName,
        public string $leaderboardType,
        public int $minMatches,
        public int $pointsPerDraw,
        public int $pointsPerLoss,
        public int $pointsPerWin,
        public string $pointsType,
        public int $rankingBoost,
        public string $rankingType,
        public int $round,
        public int $season,
        public int $startDate,
        public int $endDate,
        public int $startingPoints,
        public string $status,
        public int $group,
    ) {}

    protected static function fieldSchema(): array
    {
        return [
            'leaderboard_id' => 'string',
            'competition_id' => '?string',
            'competition_type' => '?string',
            'game_id' => '?string',
            'region' => '?string',
            'leaderboard_mode' => '?string',
            'leaderboard_name' => '?string',
            'leaderboard_type' => '?string',
            'min_matches' => '?int',
            'points_per_draw' => '?int',
            'points_per_loss' => '?int',
            'points_per_win' => '?int',
            'points_type' => '?string',
            'ranking_boost' => '?int',
            'ranking_type' => '?string',
            'round' => '?int',
            'season' => '?int',
            'start_date' => '?int',
            'end_date' => '?int',
            'starting_points' => '?int',
            'status' => '?string',
            'group' => '?int',
        ];
    }

    public static function fromArray(array $data): self
    {
        ValidationContext::pushPath('Leaderboard');
        try {
            static::validateData($data);

            return new self(
                uuid: $data['leaderboard_id'],
                competitionId: (string) ($data['competition_id'] ?? ''),
                competitionType: (string) ($data['competition_type'] ?? ''),
                gameId: (string) ($data['game_id'] ?? ''),
                region: (string) ($data['region'] ?? ''),
                leaderboardMode: (string) ($data['leaderboard_mode'] ?? ''),
                leaderboardName: (string) ($data['leaderboard_name'] ?? ''),
                leaderboardType: (string) ($data['leaderboard_type'] ?? ''),
                minMatches: (int) ($data['min_matches'] ?? 0),
                pointsPerDraw: (int) ($data['points_per_draw'] ?? 0),
                pointsPerLoss: (int) ($data['points_per_loss'] ?? 0),
                pointsPerWin: (int) ($data['points_per_win'] ?? 0),
                pointsType: (string) ($data['points_type'] ?? ''),
                rankingBoost: (int) ($data['ranking_boost'] ?? 0),
                rankingType: (string) ($data['ranking_type'] ?? ''),
                round: (int) ($data['round'] ?? 0),
                season: (int) ($data['season'] ?? 0),
                startDate: (int) ($data['start_date'] ?? 0),
                endDate: (int) ($data['end_date'] ?? 0),
                startingPoints: (int) ($data['starting_points'] ?? 0),
                status: (string) ($data['status'] ?? ''),
                group: (int) ($data['group'] ?? 0),
            );
        } finally {
            ValidationContext::popPath();
        }
    }
}
