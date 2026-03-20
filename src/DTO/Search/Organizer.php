<?php

namespace Philicevic\FaceitPhp\DTO\Search;

use Philicevic\FaceitPhp\Validation\ValidatesFields;
use Philicevic\FaceitPhp\Validation\ValidationContext;

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
        ValidationContext::pushPath('SearchOrganizer');
        try {
            static::validateData($data);

            return new self(
                organizerId: $data['organizer_id'],
                name: $data['name'],
                avatar: (string) ($data['avatar'] ?? ''),
                active: (bool) ($data['active'] ?? false),
                games: $data['games'] ?? [],
                regions: $data['regions'] ?? [],
            );
        } finally {
            ValidationContext::popPath();
        }
    }
}
