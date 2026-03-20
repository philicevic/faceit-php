<?php

namespace Philicevic\FaceitPhp\DTO\Search;

readonly class Clan
{
    public function __construct(
        public string $clanId,
        public string $name,
        public string $game,
        public string $avatar,
        public string $region,
        public int $membersCount,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            clanId: $data['id'],
            name: $data['name'],
            game: (string) ($data['game'] ?? ''),
            avatar: (string) ($data['avatar'] ?? ''),
            region: (string) ($data['region'] ?? ''),
            membersCount: (int) ($data['members_count'] ?? 0),
        );
    }
}
