<?php

namespace Philicevic\FaceitPhp\DTO\Game;

use Philicevic\FaceitPhp\Validation\ValidatesFields;
use Philicevic\FaceitPhp\Validation\ValidationContext;

readonly class MatchmakingSummary
{
    use ValidatesFields;

    public function __construct(
        public string $uuid,
        public string $name,
        public string $game,
        public string $region,
        public bool $hasLeague,
    ) {}

    protected static function fieldSchema(): array
    {
        return [
            'matchmaking_id' => '?string',
            'name' => '?string',
            'game' => '?string',
            'region' => '?string',
            'has_league' => '?bool',
        ];
    }

    public static function fromArray(array $data): self
    {
        ValidationContext::pushPath('MatchmakingSummary');
        try {
            static::validateData($data);

            return new self(
                uuid: (string) ($data['matchmaking_id'] ?? ''),
                name: (string) ($data['name'] ?? ''),
                game: (string) ($data['game'] ?? ''),
                region: (string) ($data['region'] ?? ''),
                hasLeague: (bool) ($data['has_league'] ?? false),
            );
        } finally {
            ValidationContext::popPath();
        }
    }
}
