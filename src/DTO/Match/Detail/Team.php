<?php

namespace Philicevic\FaceitPhp\DTO\Match\Detail;

class Team
{
    /**
     * @param  array<Player>  $players
     */
    public function __construct(
        public string $uuid,
        public string $name,
        public string $avatar,
        public string $leader,
        public string $type,
        public array $players,
    ) {}
}
