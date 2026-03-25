<?php

namespace Philicevic\FaceitPhp\DTO\Match\Detail;

use Philicevic\FaceitPhp\Validation\ValidatesFields;

readonly class Team
{
    use ValidatesFields;

    /**
     * @param  array<Player>  $players
     */
    public function __construct(
        public string $uuid,
        public string $name,
        public string $avatar,
        public string $leader,
        public string $type,
        public bool $substituted,
        public array $players,
    ) {}

    protected static function fieldSchema(): array
    {
        return [
            'faction_id' => 'string',
            'name' => '?string',
            'avatar' => '?string',
            'leader' => '?string',
            'type' => '?string',
            'substituted' => '?bool',
            'roster' => '?array',
        ];
    }

    public static function fromArray(array $data): self
    {
        return static::validated($data, fn ($d) => new self(
            uuid: $d['faction_id'],
            name: (string) ($d['name'] ?? ''),
            avatar: (string) ($d['avatar'] ?? ''),
            leader: (string) ($d['leader'] ?? ''),
            type: (string) ($d['type'] ?? ''),
            substituted: (bool) ($d['substituted'] ?? false),
            players: array_map(Player::fromArray(...), $d['roster'] ?? []),
        ));
    }
}
