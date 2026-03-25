<?php

namespace Philicevic\FaceitPhp\DTO;

use Philicevic\FaceitPhp\DTO\Player\PlayerPlatform;
use Philicevic\FaceitPhp\Enums\Platform;
use Philicevic\FaceitPhp\Validation\ValidatesFields;

readonly class Player
{
    use ValidatesFields;

    /**
     * @param  array<string>  $friendsIds
     * @param  array<string, GameProfile>  $games
     * @param  array<string>  $memberships
     * @param  array<Platform, string>  $platforms
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

    protected static function fieldSchema(): array
    {
        return [
            'player_id' => 'string',
            'nickname' => 'string',
            'avatar' => '?string',
            'country' => '?string',
            'cover_image' => '?string',
            'activated_at' => 'string',
            'faceit_url' => '?string',
            'friends_ids' => '?array',
            'games' => '?array',
            'memberships' => '?array',
            'platforms' => '?array',
            'membership_type' => '?string',
            'steam_id_64' => '?string',
            'steam_nickname' => '?string',
            'verified' => '?bool',
        ];
    }

    public static function fromArray(array $data): self
    {
        return static::validated($data, function ($d) {
            $games = [];
            foreach ($d['games'] ?? [] as $gameId => $game) {
                $games[$gameId] = GameProfile::fromArray($game, $gameId);
            }

            $platforms = [];
            foreach ($d['platforms'] as $platform => $gameId) {
                $platforms[] = PlayerPlatform::parse($platform, $gameId);
            }

            return new self(
                uuid: $d['player_id'],
                nickname: $d['nickname'],
                avatar: (string) ($d['avatar'] ?? ''),
                country: (string) ($d['country'] ?? ''),
                coverImage: (string) ($d['cover_image'] ?? ''),
                activatedAt: new \DateTime($d['activated_at']),
                faceitUrl: (string) ($d['faceit_url'] ?? ''),
                friendsIds: $d['friends_ids'] ?? [],
                games: $games,
                memberships: $d['memberships'] ?? [],
                platforms: $platforms,
                membershipType: (string) ($d['membership_type'] ?? ''),
                steamId64: (string) ($d['steam_id_64'] ?? ''),
                steamNickname: (string) ($d['steam_nickname'] ?? ''),
                verified: (bool) ($d['verified'] ?? false),
            );
        });
    }
}
