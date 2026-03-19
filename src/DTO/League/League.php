<?php

namespace Philicevic\FaceitPhp\DTO\League;

class League
{
    /**
     * @param  array<Division>  $divisions
     */
    public function __construct(
        public readonly string $uuid,
        public readonly string $game,
        public readonly string $region,
        public readonly int $minMatches,
        public readonly array $divisions,
    ) {}
}
