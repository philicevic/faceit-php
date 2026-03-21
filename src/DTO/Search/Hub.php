<?php

namespace Philicevic\FaceitPhp\DTO\Search;

use Philicevic\FaceitPhp\Validation\ValidatesFields;

readonly class Hub
{
    use ValidatesFields;

    public function __construct(
        public string $hubId,
        public string $name,
        public string $game,
        public string $region,
        public string $status,
        public int $slots,
    ) {}

    protected static function fieldSchema(): array
    {
        return [
            'competition_id' => 'string',
            'name' => 'string',
            'game' => '?string',
            'region' => '?string',
            'status' => '?string',
            'slots' => '?int',
        ];
    }

    public static function fromArray(array $data): self
    {
        return static::validated($data, fn ($d) => new self(
            hubId: $d['competition_id'],
            name: $d['name'],
            game: (string) ($d['game'] ?? ''),
            region: (string) ($d['region'] ?? ''),
            status: (string) ($d['status'] ?? ''),
            slots: (int) ($d['slots'] ?? 0),
        ));
    }
}
