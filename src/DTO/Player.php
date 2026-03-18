<?php

namespace Philicevic\FaceitPhp\DTO;

class Player
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
}
