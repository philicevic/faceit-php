<?php

namespace Philicevic\FaceitPhp\DTO\Team;

readonly class Team
{
    /**
     * @param  array<Member>  $members
     */
    public function __construct(
        public string $uuid,
        public string $name,
        public string $avatar,
        public string $coverImage,
        public string $description,
        public string $game,
        public string $leader,
        public string $faceitUrl,
        public string $chatRoomId,
        public array $members,
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
