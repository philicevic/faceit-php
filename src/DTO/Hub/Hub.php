<?php

namespace Philicevic\FaceitPhp\DTO\Hub;

class Hub
{
    public function __construct(
        public readonly string $uuid,
        public readonly string $name,
        public readonly string $avatar,
        public readonly string $coverImage,
        public readonly string $backgroundImage,
        public readonly string $description,
        public readonly string $gameId,
        public readonly string $region,
        public readonly string $organizerId,
        public readonly string $joinPermission,
        public readonly string $faceitUrl,
        public readonly string $chatRoomId,
        public readonly int $minSkillLevel,
        public readonly int $maxSkillLevel,
        public readonly int $playersJoined,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            uuid: $data['hub_id'],
            name: (string) ($data['name'] ?? ''),
            avatar: (string) ($data['avatar'] ?? ''),
            coverImage: (string) ($data['cover_image'] ?? ''),
            backgroundImage: (string) ($data['background_image'] ?? ''),
            description: (string) ($data['description'] ?? ''),
            gameId: (string) ($data['game_id'] ?? ''),
            region: (string) ($data['region'] ?? ''),
            organizerId: (string) ($data['organizer_id'] ?? ''),
            joinPermission: (string) ($data['join_permission'] ?? ''),
            faceitUrl: (string) ($data['faceit_url'] ?? ''),
            chatRoomId: (string) ($data['chat_room_id'] ?? ''),
            minSkillLevel: (int) ($data['min_skill_level'] ?? 0),
            maxSkillLevel: (int) ($data['max_skill_level'] ?? 0),
            playersJoined: (int) ($data['players_joined'] ?? 0),
        );
    }
}
