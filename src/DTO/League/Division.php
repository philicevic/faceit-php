<?php

namespace Philicevic\FaceitPhp\DTO\League;

readonly class Division
{
    /**
     * @param  array<string>  $leaderboards
     */
    public function __construct(
        public string $name,
        public string $type,
        public string $configType,
        public int $minElo,
        public int $maxElo,
        public array $leaderboards,
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
