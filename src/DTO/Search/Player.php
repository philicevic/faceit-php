<?php

namespace Philicevic\FaceitPhp\DTO\Search;

readonly class Player
{
    /**
     * @param  array<Game>  $games
     */
    public function __construct(
        public string $playerId,
        public string $nickname,
        public string $status,
        public string $country,
        public string $avatar,
        public bool $verified,
        public array $games,
    ) {}
}
