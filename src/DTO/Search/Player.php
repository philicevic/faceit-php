<?php

namespace Philicevic\FaceitPhp\DTO\Search;

use Philicevic\FaceitPhp\Validation\ValidatesFields;

readonly class Player
{
    use ValidatesFields;

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

    protected static function fieldSchema(): array
    {
        return [
            'player_id' => 'string',
            'nickname' => 'string',
            'status' => '?string',
            'country' => '?string',
            'avatar' => '?string',
            'verified' => '?bool',
            'games' => '?array',
        ];
    }

    public static function fromArray(array $data): self
    {
        return static::validated($data, fn ($d) => new self(
            playerId: $d['player_id'],
            nickname: $d['nickname'],
            status: (string) ($d['status'] ?? ''),
            country: (string) ($d['country'] ?? ''),
            avatar: (string) ($d['avatar'] ?? ''),
            verified: (bool) ($d['verified'] ?? false),
            games: array_map(Game::fromArray(...), $d['games'] ?? []),
        ));
    }
}
