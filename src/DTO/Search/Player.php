<?php

namespace Philicevic\FaceitPhp\DTO\Search;

use Philicevic\FaceitPhp\Validation\ValidatesFields;
use Philicevic\FaceitPhp\Validation\ValidationContext;

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
        ValidationContext::pushPath('SearchPlayer');
        try {
            static::validateData($data);

            return new self(
                playerId: $data['player_id'],
                nickname: $data['nickname'],
                status: (string) ($data['status'] ?? ''),
                country: (string) ($data['country'] ?? ''),
                avatar: (string) ($data['avatar'] ?? ''),
                verified: (bool) ($data['verified'] ?? false),
                games: array_map(Game::fromArray(...), $data['games'] ?? []),
            );
        } finally {
            ValidationContext::popPath();
        }
    }
}
