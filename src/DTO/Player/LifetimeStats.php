<?php

namespace Philicevic\FaceitPhp\DTO\Player;

class LifetimeStats
{
    /**
     * @param  array<string, mixed>  $lifetime
     * @param  array<array<string, mixed>>  $segments
     */
    public function __construct(
        public string $playerId,
        public string $gameId,
        public array $lifetime,
        public array $segments,
    ) {}
}
