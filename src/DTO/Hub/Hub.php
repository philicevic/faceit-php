<?php

namespace Philicevic\FaceitPhp\DTO\Hub;

readonly class Hub
{
    public function __construct(
        public string $uuid,
        public string $name,
        public string $avatar,
        public string $coverImage,
        public string $backgroundImage,
        public string $description,
        public string $gameId,
        public string $region,
        public string $organizerId,
        public string $joinPermission,
        public string $faceitUrl,
        public string $chatRoomId,
        public int $minSkillLevel,
        public int $maxSkillLevel,
        public int $playersJoined,
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
