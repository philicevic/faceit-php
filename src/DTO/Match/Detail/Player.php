<?php

namespace Philicevic\FaceitPhp\DTO\Match\Detail;

class Player
{
    public function __construct(
        public string $uuid,
        public string $nickname,
        public string $avatar,
        public string $membership,
        public string $gamePlayerId,
        public string $gamePlayerName,
        public int $gameSkillLevel,
        public bool $anticheatRequired,
    ) {}
}
