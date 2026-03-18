<?php

namespace Philicevic\FaceitPhp\DTO\Search;

class Team
{
    public function __construct(
        public readonly string $teamId,
        public readonly string $name,
        public readonly string $game,
        public readonly string $avatar,
        public readonly string $faceitUrl,
        public readonly bool $verified,
    ) {}
}
