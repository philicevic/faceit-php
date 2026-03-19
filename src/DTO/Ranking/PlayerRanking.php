<?php

namespace Philicevic\FaceitPhp\DTO\Ranking;

use Philicevic\FaceitPhp\DTO\PaginatedResponse;

class PlayerRanking
{
    public function __construct(
        public readonly int $position,
        public readonly PaginatedResponse $ranking,
    ) {}
}
