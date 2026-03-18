<?php

namespace Philicevic\FaceitPhp\DTO\Player;

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
        public string $membershipType,
        public string $matchType,
        public string $prizeType,
        public int $teamSize,
        public int $maxSkill,
        public int $minSkill,
        public int $subscriptionsCount,
        public int $numberOfPlayers,
        public int $numberOfPlayersJoined,
        public int $numberOfPlayersCheckedin,
        public int $numberOfPlayersParticipants,
        public \DateTime $startedAt,
        public array $whitelistCountries,
    ) {}
}
