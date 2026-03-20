<?php

namespace Philicevic\FaceitPhp\DTO\Search;

use Philicevic\FaceitPhp\Validation\ValidatesFields;
use Philicevic\FaceitPhp\Validation\ValidationContext;

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
        ValidationContext::pushPath('SearchHub');
        try {
            static::validateData($data);

            return new self(
                hubId: $data['competition_id'],
                name: $data['name'],
                game: (string) ($data['game'] ?? ''),
                region: (string) ($data['region'] ?? ''),
                status: (string) ($data['status'] ?? ''),
                slots: (int) ($data['slots'] ?? 0),
            );
        } finally {
            ValidationContext::popPath();
        }
    }
}
