<?php

namespace Philicevic\FaceitPhp\DTO;

class Ban
{
    public function __construct(
        public string $userId,
        public string $nickname,
        public string $reason,
        public string $type,
        public string $game,
        public \DateTime $startsAt,
        public \DateTime $endsAt,
    ) {}
}
