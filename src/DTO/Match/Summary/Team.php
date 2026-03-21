<?php

namespace Philicevic\FaceitPhp\DTO\Match\Summary;

use Philicevic\FaceitPhp\Validation\ValidatesFields;

readonly class Team
{
    use ValidatesFields;

    /**
     * @param  array<Player>  $players
     */
    public function __construct(
        public string $uuid,
        public string $nickname,
        public string $avatar,
        public array $players,
    ) {}

    protected static function fieldSchema(): array
    {
        return [
            'team_id' => '?string',
            'nickname' => '?string',
            'avatar' => '?string',
            'players' => '?array',
        ];
    }

    public static function fromArray(array $data): self
    {
        return static::validated($data, fn ($d) => new self(
            uuid: (string) ($d['team_id'] ?? $d['nickname']),
            nickname: (string) ($d['nickname'] ?? ''),
            avatar: (string) ($d['avatar'] ?? ''),
            players: array_map(Player::fromArray(...), $d['players'] ?? []),
        ));
    }
}
