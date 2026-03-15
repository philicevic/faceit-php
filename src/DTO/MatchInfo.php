<?php

namespace Philicevic\FaceitPhp\DTO;

readonly class MatchInfo {
    public function __construct(
        public string $uuid,
        public string $competitionId,
        public string $competitionName,
        public string $competitionType,
        public string $bestOf,
        public string $status,
    ){}
}