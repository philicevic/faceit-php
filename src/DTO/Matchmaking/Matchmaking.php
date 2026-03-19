<?php

namespace Philicevic\FaceitPhp\DTO\Matchmaking;

readonly class Matchmaking
{
    /**
     * @param  array<Queue>  $queues
     */
    public function __construct(
        public string $uuid,
        public string $name,
        public string $game,
        public string $region,
        public string $icon,
        public string $longDescription,
        public string $leagueId,
        public array $queues,
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
