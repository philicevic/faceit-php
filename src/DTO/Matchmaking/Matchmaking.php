<?php

namespace Philicevic\FaceitPhp\DTO\Matchmaking;

use Philicevic\FaceitPhp\Validation\ValidatesFields;
use Philicevic\FaceitPhp\Validation\ValidationContext;

readonly class Matchmaking
{
    use ValidatesFields;

    /**
     * @param  array<MatchmakingQueue>  $queues
     */
    public function __construct(
        public string $uuid,
        public string $name,
        public string $game,
        public string $region,
        public string $icon,
        public string $leagueId,
        public string $shortDescription,
        public string $longDescription,
        public array $queues,
    ) {}

    protected static function fieldSchema(): array
    {
        return [
            'matchmaking_id' => '?string',
            'name' => '?string',
            'game' => '?string',
            'region' => '?string',
            'icon' => '?string',
            'league_id' => '?string',
            'short_description' => '?string',
            'long_description' => '?string',
            'queues' => '?array',
        ];
    }

    public static function fromArray(array $data): self
    {
        ValidationContext::pushPath('Matchmaking');
        try {
            static::validateData($data);

            return new self(
                uuid: (string) ($data['matchmaking_id'] ?? ''),
                name: (string) ($data['name'] ?? ''),
                game: (string) ($data['game'] ?? ''),
                region: (string) ($data['region'] ?? ''),
                icon: (string) ($data['icon'] ?? ''),
                leagueId: (string) ($data['league_id'] ?? ''),
                shortDescription: (string) ($data['short_description'] ?? ''),
                longDescription: (string) ($data['long_description'] ?? ''),
                queues: array_map(
                    MatchmakingQueue::fromArray(...),
                    $data['queues'] ?? [],
                ),
            );
        } finally {
            ValidationContext::popPath();
        }
    }
}
