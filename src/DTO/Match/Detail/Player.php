<?php

namespace Philicevic\FaceitPhp\DTO\Match\Detail;

class Player
{
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

    public static function fromArray(array $data): self
    {
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
    }
}
