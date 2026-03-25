<?php

namespace Philicevic\FaceitPhp\DTO\Player;

use Philicevic\FaceitPhp\Validation\ValidatesFields;

readonly class Hub
{
    use ValidatesFields;

    public function __construct(
        public string $uuid,
        public string $name,
        public string $avatar,
        public string $faceitUrl,
        public string $gameId,
        public string $organizerId,
    ) {}

    protected static function fieldSchema(): array
    {
        return [
            'hub_id' => 'string',
            'name' => 'string',
            'avatar' => 'string',
            'faceit_url' => 'string',
            'game_id' => 'string',
            'organizer_id' => 'string',
        ];
    }

    public static function fromArray(array $data): self
    {
        return static::validated($data, fn ($d) => new self(
            uuid: $d['hub_id'],
            name: $d['name'],
            avatar: (string) ($d['avatar'] ?? ''),
            faceitUrl: (string) ($d['faceit_url'] ?? ''),
            gameId: (string) ($d['game_id'] ?? ''),
            organizerId: (string) ($d['organizer_id'] ?? ''),
        ));
    }
}
