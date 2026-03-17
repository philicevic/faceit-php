<?php

namespace Philicevic\FaceitPhp\DTO\Match;

class Team
{
    /**
     * @param  array<Player>  $players
     */
    public function __construct(
        public string $uuid,
        public bool $premade,
        public array $stats,
        public array $players
    ) {}
}
