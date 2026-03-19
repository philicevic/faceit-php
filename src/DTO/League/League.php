<?php

namespace Philicevic\FaceitPhp\DTO\League;

readonly class League
{
    /**
     * @param  array<Division>  $divisions
     */
    public function __construct(
        public string $uuid,
        public string $game,
        public string $region,
        public int $minMatches,
        public array $divisions,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            uuid: (string) ($data['league_id'] ?? ''),
            game: (string) ($data['game'] ?? ''),
            region: (string) ($data['region'] ?? ''),
            minMatches: (int) ($data['min_matches'] ?? 0),
            divisions: array_map(fn (array $d): Division => Division::fromArray($d), $data['divisions'] ?? []),
        );
    }
}
