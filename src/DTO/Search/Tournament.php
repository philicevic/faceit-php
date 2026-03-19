<?php

namespace Philicevic\FaceitPhp\DTO\Search;

readonly class Tournament
{
    public function __construct(
        public string $tournamentId,
        public string $name,
        public string $game,
        public string $region,
        public string $status,
        public string $prizeType,
    ) {}
}
