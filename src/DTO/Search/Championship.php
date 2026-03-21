<?php

namespace Philicevic\FaceitPhp\DTO\Search;

use Philicevic\FaceitPhp\Validation\ValidatesFields;

readonly class Championship
{
    use ValidatesFields;

    public function __construct(
        public string $championshipId,
        public string $name,
        public string $game,
        public string $region,
        public string $status,
        public string $type,
    ) {}

    protected static function fieldSchema(): array
    {
        return [
            'competition_id' => 'string',
            'name' => 'string',
            'game' => '?string',
            'region' => '?string',
            'status' => '?string',
            'competition_type' => '?string',
        ];
    }

    public static function fromArray(array $data): self
    {
        return static::validated($data, fn ($d) => new self(
            championshipId: $d['competition_id'],
            name: $d['name'],
            game: (string) ($d['game'] ?? ''),
            region: (string) ($d['region'] ?? ''),
            status: (string) ($d['status'] ?? ''),
            type: (string) ($d['competition_type'] ?? ''),
        ));
    }
}
