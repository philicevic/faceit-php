<?php

namespace Philicevic\FaceitPhp\DTO\Match\Stats;

class MatchStats
{
    /**
     * @param  array<Round>  $rounds
     */
    public function __construct(
        public array $rounds,
    ) {}
}
