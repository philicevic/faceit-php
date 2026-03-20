<?php

namespace Philicevic\FaceitPhp\DTO\Match\Stats;

use Philicevic\FaceitPhp\Validation\ValidatesFields;
use Philicevic\FaceitPhp\Validation\ValidationContext;

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
        ValidationContext::pushPath('Round');
        try {
            static::validateData($data);

            return new self(
                bestOf: (int) $data['best_of'],
                competitionId: $data['competition_id'],
                gameId: $data['game_id'],
                gameMode: $data['game_mode'],
                matchId: $data['match_id'],
                matchRound: (int) $data['match_round'],
                played: $data['played'] == '1',
                stats: $data['round_stats'],
                teams: array_map(Team::fromArray(...), $data['teams']),
            );
        } finally {
            ValidationContext::popPath();
        }
    }
}
