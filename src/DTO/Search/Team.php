<?php

namespace Philicevic\FaceitPhp\DTO\Search;

readonly class Team
{
    public function __construct(
        public string $teamId,
        public string $name,
        public string $game,
        public string $avatar,
        public string $faceitUrl,
        public bool $verified,
    ) {}
}
