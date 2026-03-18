<?php

namespace Philicevic\FaceitPhp\DTO\Match\Stats;

class Team
{
    /**
     * @param  array<string, mixed>  $stats
     * @param  array<Player>  $players
     */
    public function __construct(
        public string $uuid,
        public bool $premade,
        public array $stats,
        public array $players,
    ) {}
}
