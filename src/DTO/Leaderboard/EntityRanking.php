<?php

namespace Philicevic\FaceitPhp\DTO\Leaderboard;

class EntityRanking
{
    /**
     * @param  array<Ranking>  $items
     */
    public function __construct(
        public readonly int $start,
        public readonly int $end,
        public readonly Leaderboard $leaderboard,
        public readonly array $items,
    ) {}
}
