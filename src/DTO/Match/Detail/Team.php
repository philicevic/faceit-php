<?php

namespace Philicevic\FaceitPhp\DTO\Match\Detail;

use Philicevic\FaceitPhp\Validation\ValidatesFields;
use Philicevic\FaceitPhp\Validation\ValidationContext;

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
            'roster' => '?array',
        ];
    }

    public static function fromArray(array $data): self
    {
        ValidationContext::pushPath('DetailTeam');
        try {
            static::validateData($data);

            return new self(
                uuid: $data['faction_id'],
                name: (string) ($data['name'] ?? ''),
                avatar: (string) ($data['avatar'] ?? ''),
                leader: (string) ($data['leader'] ?? ''),
                type: (string) ($data['type'] ?? ''),
                players: array_map(Player::fromArray(...), $data['roster'] ?? []),
            );
        } finally {
            ValidationContext::popPath();
        }
    }
}
