<?php

namespace Philicevic\FaceitPhp\DTO\Hub;

use Philicevic\FaceitPhp\Validation\ValidatesFields;

readonly class Hub
{
    use ValidatesFields;

    public function __construct(
        public string $uuid,
        public string $name,
        public string $avatar,
        public string $backgroundImage,
        public string $coverImage,
        public string $description,
        public string $faceitUrl,
        public string $gameId,
        public string $region,
        public string $organizerId,
        public string $joinPermission,
        public int $maxSkillLevel,
        public int $minSkillLevel,
        public int $playersJoined,
        public string $ruleId,
        public string $chatRoomId,
    ) {}

    protected static function fieldSchema(): array
    {
        return [
            'hub_id' => 'string',
            'name' => 'string',
            'avatar' => '?string',
            'background_image' => '?string',
            'cover_image' => '?string',
            'description' => '?string',
            'faceit_url' => '?string',
            'game_id' => '?string',
            'region' => '?string',
            'organizer_id' => '?string',
            'join_permission' => '?string',
            'max_skill_level' => '?int',
            'min_skill_level' => '?int',
            'players_joined' => '?int',
            'rule_id' => '?string',
            'chat_room_id' => '?string',
        ];
    }

    public static function fromArray(array $data): self
    {
        return static::validated($data, fn ($d) => new self(
            uuid: $d['hub_id'],
            name: $d['name'],
            avatar: (string) ($d['avatar'] ?? ''),
            backgroundImage: (string) ($d['background_image'] ?? ''),
            coverImage: (string) ($d['cover_image'] ?? ''),
            description: (string) ($d['description'] ?? ''),
            faceitUrl: (string) ($d['faceit_url'] ?? ''),
            gameId: (string) ($d['game_id'] ?? ''),
            region: (string) ($d['region'] ?? ''),
            organizerId: (string) ($d['organizer_id'] ?? ''),
            joinPermission: (string) ($d['join_permission'] ?? ''),
            maxSkillLevel: (int) ($d['max_skill_level'] ?? 0),
            minSkillLevel: (int) ($d['min_skill_level'] ?? 0),
            playersJoined: (int) ($d['players_joined'] ?? 0),
            ruleId: (string) ($d['rule_id'] ?? ''),
            chatRoomId: (string) ($d['chat_room_id'] ?? ''),
        ));
    }
}
