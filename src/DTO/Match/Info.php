<?php

namespace Philicevic\FaceitPhp\DTO\Match;

readonly class Info
{
    public function __construct(
        public string $uuid,
        public string $competitionId,
        public string $competitionName,
        public string $competitionType,
        public int $bestOf,
        public string $status,
    ) {}
}
