<?php

namespace Philicevic\FaceitPhp\DTO;

class Player
{
    public function __construct(
        public string $uuid,
        public string $nickname,
        public string $avatar,
        public string $country,
        public string $coverImage,
        public \DateTime $activatedAt
    ) {}
}
