<?php

namespace Philicevic\FaceitPhp\DTO\Match\Detail;

use Philicevic\FaceitPhp\Validation\ValidatesFields;
use Philicevic\FaceitPhp\Validation\ValidationContext;

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
        ValidationContext::pushPath('DetailPlayer');
        try {
            static::validateData($data);

            return new self(
                uuid: $data['player_id'],
                nickname: $data['nickname'],
                avatar: (string) ($data['avatar'] ?? ''),
                membership: (string) ($data['membership'] ?? ''),
                gamePlayerId: (string) ($data['game_player_id'] ?? ''),
                gamePlayerName: (string) ($data['game_player_name'] ?? ''),
                gameSkillLevel: (int) ($data['game_skill_level'] ?? 0),
                anticheatRequired: (bool) ($data['anticheat_required'] ?? false),
            );
        } finally {
            ValidationContext::popPath();
        }
    }
}
