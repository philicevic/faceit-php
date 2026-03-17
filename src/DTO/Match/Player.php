<?php

namespace Philicevic\FaceitPhp\DTO\Match;

use Philicevic\FaceitPhp\DTO\Match\Stats\PlayerStats;

class Player
{
    public function __construct(
        public string $uuid,
        public string $nickname,
        public array $stats
    )
    {}
}