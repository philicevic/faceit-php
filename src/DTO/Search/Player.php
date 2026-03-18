<?php

namespace Philicevic\FaceitPhp\DTO\Search;

class Player
{
    /**
     * @param  array<Game>  $games
     */
    public function __construct(
        public readonly string $playerId,
        public readonly string $nickname,
        public readonly string $status,
        public readonly string $country,
        public readonly string $avatar,
        public readonly bool $verified,
        public readonly array $games,
    ) {}
}
