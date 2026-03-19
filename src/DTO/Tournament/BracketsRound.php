<?php

namespace Philicevic\FaceitPhp\DTO\Tournament;

readonly class BracketsRound
{
    public function __construct(
        public int $round,
        public string $label,
        public int $matchesCount,
        public int $bestOf,
        public int $startTime,
        public bool $startsAsap,
        public int $substitutionTime,
        public bool $substitutionsAllowed,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            round: (int) ($data['round'] ?? 0),
            label: (string) ($data['label'] ?? ''),
            matchesCount: (int) ($data['matches'] ?? 0),
            bestOf: (int) ($data['best_of'] ?? 0),
            startTime: (int) ($data['start_time'] ?? 0),
            startsAsap: (bool) ($data['starts_asap'] ?? false),
            substitutionTime: (int) ($data['substitution_time'] ?? 0),
            substitutionsAllowed: (bool) ($data['substitutions_allowed'] ?? false),
        );
    }
}
