<?php

namespace Philicevic\FaceitPhp\DTO;

readonly class Player
{
    /**
     * @param  array<string>  $friendsIds
     * @param  array<string, GameProfile>  $games
     * @param  array<string>  $memberships
     * @param  array<string, string>  $platforms
     */
    public function __construct(
        public string $uuid,
        public string $nickname,
        public string $avatar,
        public string $country,
        public string $coverImage,
        public \DateTime $activatedAt,
        public string $faceitUrl,
        public array $friendsIds,
        public array $games,
        public array $memberships,
        public array $platforms,
        public string $membershipType,
        public string $steamId64,
        public string $steamNickname,
        public bool $verified,
    ) {}

    public static function fromArray(array $data): self
    {
        $games = [];
        foreach ($data['games'] ?? [] as $gameId => $game) {
            $games[$gameId] = GameProfile::fromArray($game, $gameId);
        }

        return new self(
            uuid: $data['player_id'],
            nickname: $data['nickname'],
            avatar: (string) ($data['avatar'] ?? ''),
            country: (string) ($data['country'] ?? ''),
            coverImage: (string) ($data['cover_image'] ?? ''),
            activatedAt: new \DateTime($data['activated_at']),
            faceitUrl: (string) ($data['faceit_url'] ?? ''),
            friendsIds: $data['friends_ids'] ?? [],
            games: $games,
            memberships: $data['memberships'] ?? [],
            platforms: $data['platforms'] ?? [],
            membershipType: (string) ($data['membership_type'] ?? ''),
            steamId64: (string) ($data['steam_id_64'] ?? ''),
            steamNickname: (string) ($data['steam_nickname'] ?? ''),
            verified: (bool) ($data['verified'] ?? false),
        );
    }
}
