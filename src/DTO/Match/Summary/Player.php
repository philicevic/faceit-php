<?php

namespace Philicevic\FaceitPhp\DTO\Match\Summary;

use Philicevic\FaceitPhp\Validation\ValidatesFields;
use Philicevic\FaceitPhp\Validation\ValidationContext;

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
        ValidationContext::pushPath('SummaryPlayer');
        try {
            static::validateData($data);

            return new self(
                uuid: $data['player_id'],
                nickname: $data['nickname'],
                avatar: (string) ($data['avatar'] ?? ''),
                faceitUrl: (string) ($data['faceit_url'] ?? ''),
                gamePlayerId: (string) ($data['game_player_id'] ?? ''),
                gamePlayerName: (string) ($data['game_player_name'] ?? ''),
            );
        } finally {
            ValidationContext::popPath();
        }
    }
}
