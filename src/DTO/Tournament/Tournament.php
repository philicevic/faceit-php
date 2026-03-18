<?php

namespace Philicevic\FaceitPhp\DTO\Tournament;

class Tournament
{
    /**
     * @param  array<string>  $whitelistCountries
     */
    public function __construct(
        public string $uuid,
        public string $name,
        public string $gameId,
        public string $region,
        public string $status,
        public string $faceitUrl,
        public string $featuredImage,
        public string $coverImage,
        public string $description,
        public string $membershipType,
        public string $matchType,
        public string $prizeType,
        public string $inviteType,
        public string $organizerId,
        public int $teamSize,
        public int $maxSkill,
        public int $minSkill,
        public int $numberOfPlayers,
        public int $numberOfPlayersJoined,
        public int $numberOfPlayersCheckedin,
        public int $numberOfPlayersParticipants,
        public bool $anticheatRequired,
        public bool $calculateElo,
        public bool $custom,
        public \DateTime $startedAt,
        public array $whitelistCountries,
    ) {}
}
