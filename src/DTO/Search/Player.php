<?php

namespace Philicevic\FaceitPhp\DTO\Search;

readonly class Player
{
    /**
     * @param  array<Game>  $games
     */
    public function __construct(
        public string $playerId,
        public string $nickname,
        public string $status,
        public string $country,
        public string $avatar,
        public bool $verified,
        public array $games,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            playerId: $data['player_id'],
            nickname: $data['nickname'],
            status: (string) ($data['status'] ?? ''),
            country: (string) ($data['country'] ?? ''),
            avatar: (string) ($data['avatar'] ?? ''),
            verified: (bool) ($data['verified'] ?? false),
            games: array_map(Game::fromArray(...), $data['games'] ?? []),
        );
    }
}
