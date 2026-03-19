<?php

namespace Philicevic\FaceitPhp\DTO\Team;

class Team
{
    /**
     * @param  array<Member>  $members
     */
    public function __construct(
        public readonly string $uuid,
        public readonly string $name,
        public readonly string $avatar,
        public readonly string $coverImage,
        public readonly string $description,
        public readonly string $game,
        public readonly string $leader,
        public readonly string $faceitUrl,
        public readonly string $chatRoomId,
        public readonly array $members,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            uuid: $data['team_id'],
            name: (string) ($data['name'] ?? ''),
            avatar: (string) ($data['avatar'] ?? ''),
            coverImage: (string) ($data['cover_image'] ?? ''),
            description: (string) ($data['description'] ?? ''),
            game: (string) ($data['game'] ?? ''),
            leader: (string) ($data['leader'] ?? ''),
            faceitUrl: (string) ($data['faceit_url'] ?? ''),
            chatRoomId: (string) ($data['chat_room_id'] ?? ''),
            members: array_map(
                fn (array $m): Member => Member::fromArray($m),
                $data['members'] ?? [],
            ),
        );
    }
}
