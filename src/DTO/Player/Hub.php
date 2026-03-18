<?php

namespace Philicevic\FaceitPhp\DTO\Player;

class Hub
{
    public function __construct(
        public string $uuid,
        public string $name,
        public string $avatar,
        public string $coverImage,
        public string $backgroundImage,
        public string $faceitUrl,
        public string $description,
        public string $gameId,
        public string $region,
    ) {}
}
