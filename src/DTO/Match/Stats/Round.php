<?php

namespace Philicevic\FaceitPhp\DTO\Match\Stats;

readonly class Round
{
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

    public static function fromArray(array $data): self
    {
        return new self(
            bestOf: (int) ($data['best_of'] ?? 0),
            competitionId: (string) ($data['competition_id'] ?? ''),
            gameId: (string) ($data['game_id'] ?? ''),
            gameMode: (string) ($data['game_mode'] ?? ''),
            matchId: (string) ($data['match_id'] ?? ''),
            matchRound: (int) ($data['match_round'] ?? 0),
            played: $data['played'] == '1',
            stats: $data['round_stats'] ?? [],
            teams: array_map(fn (array $t): Team => Team::fromArray($t), $data['teams'] ?? []),
        );
    }
}
