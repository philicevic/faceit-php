<?php

namespace Philicevic\FaceitPhp\DTO\Match;

use Philicevic\FaceitPhp\DTO\Match\Stats\TeamStats;

class Team
{
    /**
     * @param string $uuid
     * @param bool $premade
     * @param array $stats
     * @param array<Player> $players
     */
    public function __construct(
        public string $uuid,
        public bool $premade,
        public array $stats,
        public array $players
    )
    {}
}