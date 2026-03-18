<?php

namespace Philicevic\FaceitPhp\DTO\Search;

class Clan
{
    public function __construct(
        public readonly string $clanId,
        public readonly string $name,
        public readonly string $game,
        public readonly string $avatar,
        public readonly string $region,
        public readonly int $membersCount,
    ) {}
}
