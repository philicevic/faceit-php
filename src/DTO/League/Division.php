<?php

namespace Philicevic\FaceitPhp\DTO\League;

class Division
{
    /**
     * @param  array<string>  $leaderboards
     */
    public function __construct(
        public readonly string $name,
        public readonly string $type,
        public readonly string $configType,
        public readonly int $minElo,
        public readonly int $maxElo,
        public readonly array $leaderboards,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            name: (string) ($data['name'] ?? ''),
            type: (string) ($data['type'] ?? ''),
            configType: (string) ($data['config_type'] ?? ''),
            minElo: (int) ($data['min_elo'] ?? 0),
            maxElo: (int) ($data['max_elo'] ?? 0),
            leaderboards: $data['leaderboards'] ?? [],
        );
    }
}
