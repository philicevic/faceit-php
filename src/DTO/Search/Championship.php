<?php

namespace Philicevic\FaceitPhp\DTO\Search;

use Philicevic\FaceitPhp\Validation\ValidatesFields;
use Philicevic\FaceitPhp\Validation\ValidationContext;

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
        ValidationContext::pushPath('SearchChampionship');
        try {
            static::validateData($data);

            return new self(
                championshipId: $data['competition_id'],
                name: $data['name'],
                game: (string) ($data['game'] ?? ''),
                region: (string) ($data['region'] ?? ''),
                status: (string) ($data['status'] ?? ''),
                type: (string) ($data['competition_type'] ?? ''),
            );
        } finally {
            ValidationContext::popPath();
        }
    }
}
