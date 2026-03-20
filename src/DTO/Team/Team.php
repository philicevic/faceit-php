<?php

namespace Philicevic\FaceitPhp\DTO\Team;

use Philicevic\FaceitPhp\DTO\UserSimple;
use Philicevic\FaceitPhp\Validation\ValidatesFields;
use Philicevic\FaceitPhp\Validation\ValidationContext;

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
        ValidationContext::pushPath('Team');
        try {
            static::validateData($data);

            return new self(
                uuid: $data['team_id'],
                name: (string) ($data['name'] ?? ''),
                nickname: (string) ($data['nickname'] ?? ''),
                avatar: (string) ($data['avatar'] ?? ''),
                coverImage: (string) ($data['cover_image'] ?? ''),
                description: (string) ($data['description'] ?? ''),
                faceitUrl: (string) ($data['faceit_url'] ?? ''),
                game: (string) ($data['game'] ?? ''),
                leader: (string) ($data['leader'] ?? ''),
                teamType: (string) ($data['team_type'] ?? ''),
                chatRoomId: (string) ($data['chat_room_id'] ?? ''),
                members: array_map(UserSimple::fromArray(...), $data['members'] ?? []),
                facebook: (string) ($data['facebook'] ?? ''),
                twitter: (string) ($data['twitter'] ?? ''),
                youtube: (string) ($data['youtube'] ?? ''),
                website: (string) ($data['website'] ?? ''),
            );
        } finally {
            ValidationContext::popPath();
        }
    }
}
