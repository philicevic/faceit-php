<?php

namespace Philicevic\FaceitPhp\DTO\Search;

class Tournament
{
    public function __construct(
        public readonly string $tournamentId,
        public readonly string $name,
        public readonly string $game,
        public readonly string $region,
        public readonly string $status,
        public readonly string $prizeType,
    ) {}
}
