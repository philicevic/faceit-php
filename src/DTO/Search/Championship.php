<?php

namespace Philicevic\FaceitPhp\DTO\Search;

readonly class Championship
{
    public function __construct(
        public string $championshipId,
        public string $name,
        public string $game,
        public string $region,
        public string $status,
        public string $type,
    ) {}
}
