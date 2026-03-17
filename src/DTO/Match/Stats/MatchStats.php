<?php

namespace Philicevic\FaceitPhp\DTO\Match\Stats;

use Philicevic\FaceitPhp\DTO\Match\Round;

class MatchStats
{
    /**
     * @param array<Round> $rounds
     */
    public function __construct(
        public array $rounds,
    )
    {
    }
}