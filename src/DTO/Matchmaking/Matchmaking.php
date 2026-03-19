<?php

namespace Philicevic\FaceitPhp\DTO\Matchmaking;

class Matchmaking
{
    /**
     * @param  array<Queue>  $queues
     */
    public function __construct(
        public readonly string $uuid,
        public readonly string $name,
        public readonly string $game,
        public readonly string $region,
        public readonly string $icon,
        public readonly string $longDescription,
        public readonly string $leagueId,
        public readonly array $queues,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            uuid: $data['id'],
            name: (string) ($data['name'] ?? ''),
            game: (string) ($data['game'] ?? ''),
            region: (string) ($data['region'] ?? ''),
            icon: (string) ($data['icon'] ?? ''),
            longDescription: (string) ($data['long_description'] ?? ''),
            leagueId: (string) ($data['league_id'] ?? ''),
            queues: array_map(
                fn (array $q): Queue => Queue::fromArray($q),
                $data['queues'] ?? [],
            ),
        );
    }
}
