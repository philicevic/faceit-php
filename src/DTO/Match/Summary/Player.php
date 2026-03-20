<?php

namespace Philicevic\FaceitPhp\DTO\Match\Summary;

readonly class Player
{
    public function __construct(
        public string $uuid,
        public string $nickname,
        public string $avatar,
        public string $faceitUrl,
        public string $gamePlayerId,
        public string $gamePlayerName,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            uuid: $data['player_id'],
            nickname: $data['nickname'],
            avatar: (string) ($data['avatar'] ?? ''),
            faceitUrl: (string) ($data['faceit_url'] ?? ''),
            gamePlayerId: (string) ($data['game_player_id'] ?? ''),
            gamePlayerName: (string) ($data['game_player_name'] ?? ''),
        );
    }
}
