<?php

namespace Philicevic\FaceitPhp\DTO\Search;

use Philicevic\FaceitPhp\Validation\ValidatesFields;

readonly class Organizer
{
    use ValidatesFields;

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

    protected static function fieldSchema(): array
    {
        return [
            'organizer_id' => 'string',
            'name' => 'string',
            'avatar' => '?string',
            'active' => '?bool',
            'games' => '?array',
            'regions' => '?array',
        ];
    }

    public static function fromArray(array $data): self
    {
        return static::validated($data, fn ($d) => new self(
            organizerId: $d['organizer_id'],
            name: $d['name'],
            avatar: (string) ($d['avatar'] ?? ''),
            active: (bool) ($d['active'] ?? false),
            games: $d['games'] ?? [],
            regions: $d['regions'] ?? [],
        ));
    }
}
