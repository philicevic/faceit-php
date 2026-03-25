<?php

namespace Philicevic\FaceitPhp\DTO;

readonly class MatchScore
{
    /**
     * @param  array<string, int|string>  $byFaction
     */
    public function __construct(
        public array $byFaction,
    ) {}
}
