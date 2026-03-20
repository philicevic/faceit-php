<?php

namespace Philicevic\FaceitPhp\DTO\Player;

readonly class GameMatchStats
{
    /**
     * @param  array<string, mixed>  $stats
     */
    public function __construct(
        public array $stats,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(stats: $data['stats'] ?? []);
    }
}
