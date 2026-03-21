<?php

namespace Philicevic\FaceitPhp\DTO\Leaderboard;

use Philicevic\FaceitPhp\Validation\ValidatesFields;

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
        return static::validated($data, fn ($d) => new self(
            uuid: $d['leaderboard_id'],
            competitionId: (string) ($d['competition_id'] ?? ''),
            competitionType: (string) ($d['competition_type'] ?? ''),
            gameId: (string) ($d['game_id'] ?? ''),
            region: (string) ($d['region'] ?? ''),
            leaderboardMode: (string) ($d['leaderboard_mode'] ?? ''),
            leaderboardName: (string) ($d['leaderboard_name'] ?? ''),
            leaderboardType: (string) ($d['leaderboard_type'] ?? ''),
            minMatches: (int) ($d['min_matches'] ?? 0),
            pointsPerDraw: (int) ($d['points_per_draw'] ?? 0),
            pointsPerLoss: (int) ($d['points_per_loss'] ?? 0),
            pointsPerWin: (int) ($d['points_per_win'] ?? 0),
            pointsType: (string) ($d['points_type'] ?? ''),
            rankingBoost: (int) ($d['ranking_boost'] ?? 0),
            rankingType: (string) ($d['ranking_type'] ?? ''),
            round: (int) ($d['round'] ?? 0),
            season: (int) ($d['season'] ?? 0),
            startDate: (int) ($d['start_date'] ?? 0),
            endDate: (int) ($d['end_date'] ?? 0),
            startingPoints: (int) ($d['starting_points'] ?? 0),
            status: (string) ($d['status'] ?? ''),
            group: (int) ($d['group'] ?? 0),
        ));
    }
}
