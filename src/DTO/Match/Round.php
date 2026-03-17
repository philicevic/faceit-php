<?php

namespace Philicevic\FaceitPhp\DTO\Match;

use Philicevic\FaceitPhp\DTO\Match\Stats\RoundStats;

class Round
{
    /**
     * @param int $bestOf
     * @param string $competitionId
     * @param string $gameId
     * @param string $gameMode
     * @param string $matchId
     * @param int $matchRound
     * @param bool $played
     * @param array $stats
     * @param array<Team> $teams
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
    )
    {
    }
}