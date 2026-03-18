<?php

namespace Philicevic\FaceitPhp\DTO;

class GameProfile
{
    /**
     * @param  array<string, mixed>  $regions
     */
    public function __construct(
        public string $gameId,
        public string $gamePlayerId,
        public string $gamePlayerName,
        public string $gameProfileId,
        public string $region,
        public int $skillLevel,
        public string $skillLevelLabel,
        public int $faceitElo,
        public array $regions = [],
    ) {}
}
