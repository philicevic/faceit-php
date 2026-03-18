<?php

namespace Philicevic\FaceitPhp\DTO\Tournament;

class Team
{
    public function __construct(
        public string $uuid,
        public string $nickname,
        public string $teamLeader,
        public string $teamType,
        public int $skillLevel,
        public int $subsDone,
    ) {}
}
