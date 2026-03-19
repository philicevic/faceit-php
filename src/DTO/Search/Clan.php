<?php

namespace Philicevic\FaceitPhp\DTO\Search;

readonly class Clan
{
    public function __construct(
        public string $clanId,
        public string $name,
        public string $game,
        public string $avatar,
        public string $region,
        public int $membersCount,
    ) {}
}
