<?php

namespace Philicevic\FaceitPhp\DTO\Match\Stats;

use Philicevic\FaceitPhp\Validation\ValidatesFields;

readonly class Round
{
    use ValidatesFields;

    /**
     * @param  array<string, mixed>  $stats
     * @param  array<Team>  $teams
     */
    public function __construct(
        public int $bestOf,
        public string $competitionId,
        public string $gameId,
        public string $gameMode,
        public string $matchId,
        public int $matchRound,
        public bool $played,
        public array $stats,
        public array $teams,
    ) {}

    protected static function fieldSchema(): array
    {
        return [
            'best_of' => 'string',
            'competition_id' => 'string',
            'game_id' => 'string',
            'game_mode' => 'string',
            'match_id' => 'string',
            'match_round' => 'string',
            'played' => 'string',
            'round_stats' => 'array',
            'teams' => 'array',
        ];
    }

    public static function fromArray(array $data): self
    {
        return static::validated($data, fn ($d) => new self(
            bestOf: (int) $d['best_of'],
            competitionId: $d['competition_id'],
            gameId: $d['game_id'],
            gameMode: $d['game_mode'],
            matchId: $d['match_id'],
            matchRound: (int) $d['match_round'],
            played: $d['played'] == '1',
            stats: $d['round_stats'],
            teams: array_map(Team::fromArray(...), $d['teams']),
        ));
    }
}
