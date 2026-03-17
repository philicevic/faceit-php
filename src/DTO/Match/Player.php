<?php

namespace Philicevic\FaceitPhp\DTO\Match;

class Player
{
    public function __construct(
        public string $uuid,
        public string $nickname,
        public array $stats
    ) {}
}
