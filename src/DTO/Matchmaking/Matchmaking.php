<?php

namespace Philicevic\FaceitPhp\DTO\Matchmaking;

use Philicevic\FaceitPhp\Validation\ValidatesFields;

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
        return static::validated($data, fn ($d) => new self(
            uuid: (string) ($d['matchmaking_id'] ?? ''),
            name: (string) ($d['name'] ?? ''),
            game: (string) ($d['game'] ?? ''),
            region: (string) ($d['region'] ?? ''),
            icon: (string) ($d['icon'] ?? ''),
            leagueId: (string) ($d['league_id'] ?? ''),
            shortDescription: (string) ($d['short_description'] ?? ''),
            longDescription: (string) ($d['long_description'] ?? ''),
            queues: array_map(
                MatchmakingQueue::fromArray(...),
                $d['queues'] ?? [],
            ),
        ));
    }
}
