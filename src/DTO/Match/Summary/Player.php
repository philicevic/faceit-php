<?php

namespace Philicevic\FaceitPhp\DTO\Match\Summary;

use Philicevic\FaceitPhp\Validation\ValidatesFields;

readonly class Player
{
    use ValidatesFields;

    public function __construct(
        public string $uuid,
        public string $nickname,
        public string $avatar,
        public string $faceitUrl,
        public string $gamePlayerId,
        public string $gamePlayerName,
    ) {}

    protected static function fieldSchema(): array
    {
        return [
            'player_id' => 'string',
            'nickname' => 'string',
            'avatar' => '?string',
            'faceit_url' => '?string',
            'game_player_id' => '?string',
            'game_player_name' => '?string',
        ];
    }

    public static function fromArray(array $data): self
    {
        return static::validated($data, fn ($d) => new self(
            uuid: $d['player_id'],
            nickname: $d['nickname'],
            avatar: (string) ($d['avatar'] ?? ''),
            faceitUrl: (string) ($d['faceit_url'] ?? ''),
            gamePlayerId: (string) ($d['game_player_id'] ?? ''),
            gamePlayerName: (string) ($d['game_player_name'] ?? ''),
        ));
    }
}
