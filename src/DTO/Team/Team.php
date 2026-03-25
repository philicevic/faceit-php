<?php

namespace Philicevic\FaceitPhp\DTO\Team;

use Philicevic\FaceitPhp\DTO\UserSimple;
use Philicevic\FaceitPhp\Validation\ValidatesFields;

readonly class Team
{
    use ValidatesFields;

    /**
     * @param  array<UserSimple>  $members
     */
    public function __construct(
        public string $uuid,
        public string $name,
        public string $nickname,
        public string $avatar,
        public string $coverImage,
        public string $description,
        public string $faceitUrl,
        public string $game,
        public string $leader,
        public string $teamType,
        public string $chatRoomId,
        public array $members,
        public string $facebook = '',
        public string $twitter = '',
        public string $youtube = '',
        public string $website = '',
    ) {}

    protected static function fieldSchema(): array
    {
        return [
            'team_id' => 'string',
            'name' => '?string',
            'nickname' => '?string',
            'avatar' => '?string',
            'cover_image' => '?string',
            'description' => '?string',
            'faceit_url' => '?string',
            'game' => '?string',
            'leader' => '?string',
            'team_type' => '?string',
            'chat_room_id' => '?string',
            'members' => '?array',
            'facebook' => '?string',
            'twitter' => '?string',
            'youtube' => '?string',
            'website' => '?string',
        ];
    }

    public static function fromArray(array $data): self
    {
        return static::validated($data, fn ($d) => new self(
            uuid: $d['team_id'],
            name: (string) ($d['name'] ?? ''),
            nickname: (string) ($d['nickname'] ?? ''),
            avatar: (string) ($d['avatar'] ?? ''),
            coverImage: (string) ($d['cover_image'] ?? ''),
            description: (string) ($d['description'] ?? ''),
            faceitUrl: (string) ($d['faceit_url'] ?? ''),
            game: (string) ($d['game'] ?? ''),
            leader: (string) ($d['leader'] ?? ''),
            teamType: (string) ($d['team_type'] ?? ''),
            chatRoomId: (string) ($d['chat_room_id'] ?? ''),
            members: array_map(UserSimple::fromArray(...), $d['members'] ?? []),
            facebook: (string) ($d['facebook'] ?? ''),
            twitter: (string) ($d['twitter'] ?? ''),
            youtube: (string) ($d['youtube'] ?? ''),
            website: (string) ($d['website'] ?? ''),
        ));
    }
}
