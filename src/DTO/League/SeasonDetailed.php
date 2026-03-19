<?php

namespace Philicevic\FaceitPhp\DTO\League;

class SeasonDetailed
{
    /**
     * @param  array<Division>  $divisions
     */
    public function __construct(
        public readonly Season $season,
        public readonly array $divisions,
    ) {}
}
