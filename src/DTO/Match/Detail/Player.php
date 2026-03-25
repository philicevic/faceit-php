<?php

namespace Philicevic\FaceitPhp\DTO\Match\Detail;

use Philicevic\FaceitPhp\Validation\ValidatesFields;

readonly class Player
{
    use ValidatesFields;

    public function __construct(
        public string $uuid,
        public string $nickname,
        public string $avatar,
        public string $membership,
        public string $gamePlayerId,
        public string $gamePlayerName,
        public int $gameSkillLevel,
        public bool $anticheatRequired,
    ) {}

    protected static function fieldSchema(): array
    {
        return [
            'player_id' => 'string',
            'nickname' => 'string',
            'avatar' => '?string',
            'membership' => '?string',
            'game_player_id' => '?string',
            'game_player_name' => '?string',
            'game_skill_level' => '?int',
            'anticheat_required' => '?bool',
        ];
    }

    public static function fromArray(array $data): self
    {
        return static::validated($data, fn ($d) => new self(
            uuid: $d['player_id'],
            nickname: $d['nickname'],
            avatar: (string) ($d['avatar'] ?? ''),
            membership: (string) ($d['membership'] ?? ''),
            gamePlayerId: (string) ($d['game_player_id'] ?? ''),
            gamePlayerName: (string) ($d['game_player_name'] ?? ''),
            gameSkillLevel: (int) ($d['game_skill_level'] ?? 0),
            anticheatRequired: (bool) ($d['anticheat_required'] ?? false),
        ));
    }
}
