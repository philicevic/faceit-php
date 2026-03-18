<?php

namespace Philicevic\FaceitPhp\DTO\Tournament;

class BracketsRound
{
    public function __construct(
        public int $round,
        public string $label,
        public int $matchesCount,
        public int $bestOf,
        public int $startTime,
        public bool $startsAsap,
        public int $substitutionTime,
        public bool $substitutionsAllowed,
    ) {}
}
