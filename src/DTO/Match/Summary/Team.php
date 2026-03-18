<?php

namespace Philicevic\FaceitPhp\DTO\Match\Summary;

class Team
{
    /**
     * @param  array<Player>  $players
     */
    public function __construct(
        public string $uuid,
        public string $nickname,
        public string $avatar,
        public array $players,
    ) {}
}
