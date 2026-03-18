<?php

namespace Philicevic\FaceitPhp\DTO\Match\Summary;

use Philicevic\FaceitPhp\DTO\MatchResult;

class Info
{
    /**
     * @param  array<Team>  $teams
     * @param  array<string>  $playingPlayers
     */
    public function __construct(
        public string $uuid,
        public string $competitionId,
        public string $competitionName,
        public string $competitionType,
        public string $status,
        public string $gameId,
        public string $gameMode,
        public string $matchType,
        public int $maxPlayers,
        public string $organizerId,
        public string $region,
        public string $faceitUrl,
        public \DateTime $startedAt,
        public \DateTime $finishedAt,
        public MatchResult $results,
        public array $teams,
        public array $playingPlayers,
    ) {}
}
