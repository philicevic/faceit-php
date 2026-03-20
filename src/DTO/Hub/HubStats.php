<?php

namespace Philicevic\FaceitPhp\DTO\Hub;

use Philicevic\FaceitPhp\Validation\ValidatesFields;
use Philicevic\FaceitPhp\Validation\ValidationContext;

readonly class HubStats
{
    use ValidatesFields;

    /**
     * @param  array<HubStatsPlayer>  $players
     */
    public function __construct(
        public string $gameId,
        public array $players,
    ) {}

    protected static function fieldSchema(): array
    {
        return [
            'game_id' => '?string',
            'players' => '?array',
        ];
    }

    public static function fromArray(array $data): self
    {
        ValidationContext::pushPath('HubStats');
        try {
            static::validateData($data);

            return new self(
                gameId: (string) ($data['game_id'] ?? ''),
                players: array_map(HubStatsPlayer::fromArray(...), $data['players'] ?? []),
            );
        } finally {
            ValidationContext::popPath();
        }
    }
}
