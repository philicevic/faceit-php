<?php

namespace Philicevic\FaceitPhp\DTO\Match\Detail;

class Team
{
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

    public static function fromArray(array $data): self
    {
        return new self(
            uuid: $data['faction_id'],
            name: (string) ($data['name'] ?? ''),
            avatar: (string) ($data['avatar'] ?? ''),
            leader: (string) ($data['leader'] ?? ''),
            type: (string) ($data['type'] ?? ''),
            players: array_map(
                fn (array $p): Player => Player::fromArray($p),
                $data['roster'] ?? [],
            ),
        );
    }
}
