<?php

namespace Philicevic\FaceitPhp\DTO\Match\Stats;

class Player
{
    /**
     * @param  array<string, mixed>  $stats
     */
    public function __construct(
        public string $uuid,
        public string $nickname,
        public array $stats,
    ) {}
}
