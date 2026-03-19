<?php

namespace Philicevic\FaceitPhp\DTO\League;

class Season
{
    public function __construct(
        public readonly int $number,
        public readonly string $startDate,
        public readonly string $endDate,
        public readonly int $placementMatchCount,
    ) {}
}
