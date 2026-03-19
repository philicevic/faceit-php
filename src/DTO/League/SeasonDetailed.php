<?php

namespace Philicevic\FaceitPhp\DTO\League;

readonly class SeasonDetailed
{
    /**
     * @param  array<Division>  $divisions
     */
    public function __construct(
        public Season $season,
        public array $divisions,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            season: Season::fromArray($data['season'] ?? $data),
            divisions: array_map(fn (array $d): Division => Division::fromArray($d), $data['divisions'] ?? []),
        );
    }
}
