<?php

namespace Philicevic\FaceitPhp\DTO\Search;

use Philicevic\FaceitPhp\Validation\ValidatesFields;
use Philicevic\FaceitPhp\Validation\ValidationContext;

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
        ValidationContext::pushPath('SearchTournament');
        try {
            static::validateData($data);

            return new self(
                tournamentId: $data['competition_id'],
                name: $data['name'],
                game: (string) ($data['game'] ?? ''),
                region: (string) ($data['region'] ?? ''),
                status: (string) ($data['status'] ?? ''),
                prizeType: (string) ($data['prize_type'] ?? ''),
            );
        } finally {
            ValidationContext::popPath();
        }
    }
}
