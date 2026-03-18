<?php

namespace Philicevic\FaceitPhp\DTO\Match\Detail;

use Philicevic\FaceitPhp\DTO\MatchResult;

class Info
{
    /**
     * @param  array<Team>  $teams
     */
    public function __construct(
        public string $uuid,
        public string $competitionId,
        public string $competitionName,
        public string $competitionType,
        public int $bestOf,
        public string $status,
        public string $game,
        public string $region,
        public string $organizerId,
        public ?\DateTime $startedAt,
        public ?\DateTime $finishedAt,
        public ?\DateTime $scheduledAt,
        public string $faceitUrl,
        public MatchResult $results,
        public array $teams,
    ) {}
}
