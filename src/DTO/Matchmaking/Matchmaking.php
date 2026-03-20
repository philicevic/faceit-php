<?php

namespace Philicevic\FaceitPhp\DTO\Matchmaking;

readonly class Matchmaking
{
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

    public static function fromArray(array $data): self
    {
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
    }
}
