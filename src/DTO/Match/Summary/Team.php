<?php

namespace Philicevic\FaceitPhp\DTO\Match\Summary;

use Philicevic\FaceitPhp\Validation\ValidatesFields;
use Philicevic\FaceitPhp\Validation\ValidationContext;

readonly class Team
{
    use ValidatesFields;

    /**
     * @param  array<Player>  $players
     */
    public function __construct(
        public string $uuid,
        public string $nickname,
        public string $avatar,
        public array $players,
    ) {}

    protected static function fieldSchema(): array
    {
        return [
            'team_id' => '?string',
            'nickname' => '?string',
            'avatar' => '?string',
            'players' => '?array',
        ];
    }

    public static function fromArray(array $data): self
    {
        ValidationContext::pushPath('SummaryTeam');
        try {
            static::validateData($data);

            return new self(
                uuid: (string) ($data['team_id'] ?? $data['nickname']),
                nickname: (string) ($data['nickname'] ?? ''),
                avatar: (string) ($data['avatar'] ?? ''),
                players: array_map(Player::fromArray(...), $data['players'] ?? []),
            );
        } finally {
            ValidationContext::popPath();
        }
    }
}
