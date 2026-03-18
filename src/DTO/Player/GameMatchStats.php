<?php

namespace Philicevic\FaceitPhp\DTO\Player;

class GameMatchStats
{
    /**
     * @param  array<string, mixed>  $stats
     */
    public function __construct(
        public array $stats,
    ) {}
}
