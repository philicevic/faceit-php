<?php

namespace Philicevic\FaceitPhp\DTO\Search;

readonly class Tournament
{
    public function __construct(
        public string $tournamentId,
        public string $name,
        public string $game,
        public string $region,
        public string $status,
        public string $prizeType,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            tournamentId: $data['competition_id'],
            name: $data['name'],
            game: (string) ($data['game'] ?? ''),
            region: (string) ($data['region'] ?? ''),
            status: (string) ($data['status'] ?? ''),
            prizeType: (string) ($data['prize_type'] ?? ''),
        );
    }
}
