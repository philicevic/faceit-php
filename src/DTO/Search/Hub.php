<?php

namespace Philicevic\FaceitPhp\DTO\Search;

readonly class Hub
{
    public function __construct(
        public string $hubId,
        public string $name,
        public string $game,
        public string $region,
        public string $status,
        public int $slots,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            hubId: $data['competition_id'],
            name: $data['name'],
            game: (string) ($data['game'] ?? ''),
            region: (string) ($data['region'] ?? ''),
            status: (string) ($data['status'] ?? ''),
            slots: (int) ($data['slots'] ?? 0),
        );
    }
}
