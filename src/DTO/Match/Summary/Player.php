<?php

namespace Philicevic\FaceitPhp\DTO\Match\Summary;

class Player
{
    public function __construct(
        public string $uuid,
        public string $nickname,
        public string $avatar,
        public string $faceitUrl,
        public string $gamePlayerId,
        public string $gamePlayerName,
    ) {}
}
