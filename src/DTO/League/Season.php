<?php

namespace Philicevic\FaceitPhp\DTO\League;

readonly class Season
{
    public function __construct(
        public int $number,
        public string $startDate,
        public string $endDate,
        public int $placementMatchCount,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            number: (int) ($data['season_number'] ?? $data['number'] ?? 0),
            startDate: (string) ($data['start_date'] ?? ''),
            endDate: (string) ($data['end_date'] ?? ''),
            placementMatchCount: (int) ($data['placement_match_count'] ?? 0),
        );
    }
}
