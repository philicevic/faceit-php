<?php

namespace Philicevic\FaceitPhp\DTO\Player;

use Philicevic\FaceitPhp\Validation\ValidatesFields;

class Team
{
    use ValidatesFields;

    public function __construct(
        public string $uuid,
        public string $name,
        public string $nickname,
        public string $avatar,
        public string $description,
        public string $faceitUrl,
        public string $game,
        public string $leader,
        public string $teamType,
        public string $chatRoomId,
    ) {}

    protected static function fieldSchema(): array
    {
        return [
            'team_id' => 'string',
            'name' => 'string',
            'nickname' => 'string',
            'avatar' => 'string',
            'description' => 'string',
            'faceit_url' => 'string',
            'game' => 'string',
            'leader' => 'string',
            'team_type' => 'string',
            'chat_room_id' => 'string',
        ];
    }

    public static function fromArray(array $data): self
    {
        return static::validated($data, fn ($d) => new self(
            uuid: $d['team_id'],
            name: (string) ($d['name'] ?? ''),
            nickname: (string) ($d['nickname'] ?? ''),
            avatar: (string) ($d['avatar'] ?? ''),
            description: (string) ($d['description'] ?? ''),
            faceitUrl: (string) ($d['faceit_url'] ?? ''),
            game: (string) ($d['game'] ?? ''),
            leader: (string) ($d['leader'] ?? ''),
            teamType: (string) ($d['team_type'] ?? ''),
            chatRoomId: (string) ($d['chat_room_id'] ?? ''),
        ));
    }
}
