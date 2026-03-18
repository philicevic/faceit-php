<?php

namespace Philicevic\FaceitPhp\DTO;

class MatchResult
{
    public function __construct(
        public string $winner,
        public MatchScore $score,
    ) {}
}
