<?php

namespace Philicevic\FaceitPhp\DTO\Ranking;

use Philicevic\FaceitPhp\DTO\PaginatedResponse;

readonly class PlayerRanking
{
    public function __construct(
        public int $position,
        public PaginatedResponse $ranking,
    ) {}
}
