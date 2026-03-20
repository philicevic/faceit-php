<?php

namespace Philicevic\FaceitPhp\DTO\Tournament;

use Philicevic\FaceitPhp\DTO\MatchResult;

readonly class BracketsMatch
{
    public function __construct(
        public string $uuid,
        public string $faceitUrl,
        public int $round,
        public int $position,
        public string $state,
        public ?MatchResult $results,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            uuid: $data['match_id'],
            faceitUrl: (string) ($data['faceit_url'] ?? ''),
            round: (int) ($data['round'] ?? 0),
            position: (int) ($data['position'] ?? 0),
            state: (string) ($data['state'] ?? ''),
            results: isset($data['results']) ? MatchResult::fromArray($data['results']) : null,
        );
    }
}
