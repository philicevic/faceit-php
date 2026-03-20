<?php

namespace Philicevic\FaceitPhp\DTO\Search;

readonly class Championship
{
    public function __construct(
        public string $championshipId,
        public string $name,
        public string $game,
        public string $region,
        public string $status,
        public string $type,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            championshipId: $data['competition_id'],
            name: $data['name'],
            game: (string) ($data['game'] ?? ''),
            region: (string) ($data['region'] ?? ''),
            status: (string) ($data['status'] ?? ''),
            type: (string) ($data['competition_type'] ?? ''),
        );
    }
}
