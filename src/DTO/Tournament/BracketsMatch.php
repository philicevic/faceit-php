<?php

namespace Philicevic\FaceitPhp\DTO\Tournament;

use Philicevic\FaceitPhp\DTO\MatchResult;

class BracketsMatch
{
    public function __construct(
        public string $uuid,
        public string $faceitUrl,
        public int $round,
        public int $position,
        public string $state,
        public ?MatchResult $results,
    ) {}
}
