<?php

namespace Philicevic\FaceitPhp\DTO\Tournament;

readonly class Tournament
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

    public static function fromArray(array $data): self
    {
        return new self(
            uuid: $data['tournament_id'],
            name: $data['name'],
            gameId: (string) ($data['game_id'] ?? ''),
            region: (string) ($data['region'] ?? ''),
            status: (string) ($data['status'] ?? ''),
            faceitUrl: (string) ($data['faceit_url'] ?? ''),
            featuredImage: (string) ($data['featured_image'] ?? ''),
            coverImage: (string) ($data['cover_image'] ?? ''),
            description: (string) ($data['description'] ?? ''),
            membershipType: (string) ($data['membership_type'] ?? ''),
            matchType: (string) ($data['match_type'] ?? ''),
            prizeType: (string) ($data['prize_type'] ?? ''),
            inviteType: (string) ($data['invite_type'] ?? ''),
            organizerId: (string) ($data['organizer_id'] ?? ''),
            teamSize: (int) ($data['team_size'] ?? 0),
            maxSkill: (int) ($data['max_skill'] ?? 0),
            minSkill: (int) ($data['min_skill'] ?? 0),
            numberOfPlayers: (int) ($data['number_of_players'] ?? 0),
            numberOfPlayersJoined: (int) ($data['number_of_players_joined'] ?? 0),
            numberOfPlayersCheckedin: (int) ($data['number_of_players_checkedin'] ?? 0),
            numberOfPlayersParticipants: (int) ($data['number_of_players_participants'] ?? 0),
            anticheatRequired: (bool) ($data['anticheat_required'] ?? false),
            calculateElo: (bool) ($data['calculate_elo'] ?? false),
            custom: (bool) ($data['custom'] ?? false),
            startedAt: new \DateTime('@'.(int) ($data['started_at'] ?? 0)),
            whitelistCountries: $data['whitelist_countries'] ?? [],
        );
    }
}
