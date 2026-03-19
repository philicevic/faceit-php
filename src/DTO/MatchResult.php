<?php

namespace Philicevic\FaceitPhp\DTO;

readonly class MatchResult
{
    public function __construct(
        public string $winner,
        public MatchScore $score,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            winner: (string) ($data['winner'] ?? ''),
            score: new MatchScore(byFaction: $data['score'] ?? []),
        );
    }
}
