<?php

namespace Philicevic\FaceitPhp\DTO\Match\Stats;

class Round
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
}
