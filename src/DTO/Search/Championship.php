<?php

namespace Philicevic\FaceitPhp\DTO\Search;

class Championship
{
    public function __construct(
        public readonly string $championshipId,
        public readonly string $name,
        public readonly string $game,
        public readonly string $region,
        public readonly string $status,
        public readonly string $type,
    ) {}
}
