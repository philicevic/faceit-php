<?php

namespace Philicevic\FaceitPhp\DTO\Match\Summary;

readonly class Team
{
    /**
     * @param  array<Player>  $players
     */
    public function __construct(
        public string $uuid,
        public string $nickname,
        public string $avatar,
        public array $players,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            uuid: (string) ($data['team_id'] ?? $data['nickname']),
            nickname: (string) ($data['nickname'] ?? ''),
            avatar: (string) ($data['avatar'] ?? ''),
            players: array_map(Player::fromArray(...), $data['players'] ?? []),
        );
    }
}
