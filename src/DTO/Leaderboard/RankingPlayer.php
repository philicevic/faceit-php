<?php

namespace Philicevic\FaceitPhp\DTO\Leaderboard;

class RankingPlayer
{
    /**
     * @param  array<string>  $memberships
     */
    public function __construct(
        public readonly string $uuid,
        public readonly string $nickname,
        public readonly string $avatar,
        public readonly string $country,
        public readonly string $faceitUrl,
        public readonly string $membershipType,
        public readonly int $skillLevel,
        public readonly array $memberships,
    ) {}
}
