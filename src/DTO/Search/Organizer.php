<?php

namespace Philicevic\FaceitPhp\DTO\Search;

readonly class Organizer
{
    /**
     * @param  array<string>  $games
     * @param  array<string>  $regions
     */
    public function __construct(
        public string $organizerId,
        public string $name,
        public string $avatar,
        public bool $active,
        public array $games,
        public array $regions,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            organizerId: $data['organizer_id'],
            name: $data['name'],
            avatar: (string) ($data['avatar'] ?? ''),
            active: (bool) ($data['active'] ?? false),
            games: $data['games'] ?? [],
            regions: $data['regions'] ?? [],
        );
    }
}
