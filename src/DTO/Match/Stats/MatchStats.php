<?php

namespace Philicevic\FaceitPhp\DTO\Match\Stats;

readonly class MatchStats
{
    /**
     * @param  array<Round>  $rounds
     */
    public function __construct(
        public array $rounds,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            rounds: array_map(fn (array $r): Round => Round::fromArray($r), $data['rounds'] ?? []),
        );
    }
}
