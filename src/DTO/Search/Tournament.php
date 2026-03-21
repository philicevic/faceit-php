<?php

namespace Philicevic\FaceitPhp\DTO\Search;

use Philicevic\FaceitPhp\Validation\ValidatesFields;

readonly class Tournament
{
    use ValidatesFields;

    public function __construct(
        public string $tournamentId,
        public string $name,
        public string $game,
        public string $region,
        public string $status,
        public string $prizeType,
    ) {}

    protected static function fieldSchema(): array
    {
        return [
            'competition_id' => 'string',
            'name' => 'string',
            'game' => '?string',
            'region' => '?string',
            'status' => '?string',
            'prize_type' => '?string',
        ];
    }

    public static function fromArray(array $data): self
    {
        return static::validated($data, fn ($d) => new self(
            tournamentId: $d['competition_id'],
            name: $d['name'],
            game: (string) ($d['game'] ?? ''),
            region: (string) ($d['region'] ?? ''),
            status: (string) ($d['status'] ?? ''),
            prizeType: (string) ($d['prize_type'] ?? ''),
        ));
    }
}
