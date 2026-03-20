<?php

namespace Philicevic\FaceitPhp\DTO\Hub;

use Philicevic\FaceitPhp\Validation\ValidatesFields;
use Philicevic\FaceitPhp\Validation\ValidationContext;

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
        ValidationContext::pushPath('Hub');
        try {
            static::validateData($data);

            return new self(
                uuid: $data['hub_id'],
                name: $data['name'],
                avatar: (string) ($data['avatar'] ?? ''),
                backgroundImage: (string) ($data['background_image'] ?? ''),
                coverImage: (string) ($data['cover_image'] ?? ''),
                description: (string) ($data['description'] ?? ''),
                faceitUrl: (string) ($data['faceit_url'] ?? ''),
                gameId: (string) ($data['game_id'] ?? ''),
                region: (string) ($data['region'] ?? ''),
                organizerId: (string) ($data['organizer_id'] ?? ''),
                joinPermission: (string) ($data['join_permission'] ?? ''),
                maxSkillLevel: (int) ($data['max_skill_level'] ?? 0),
                minSkillLevel: (int) ($data['min_skill_level'] ?? 0),
                playersJoined: (int) ($data['players_joined'] ?? 0),
                ruleId: (string) ($data['rule_id'] ?? ''),
                chatRoomId: (string) ($data['chat_room_id'] ?? ''),
            );
        } finally {
            ValidationContext::popPath();
        }
    }
}
