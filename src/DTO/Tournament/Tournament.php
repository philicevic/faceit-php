<?php

namespace Philicevic\FaceitPhp\DTO\Tournament;

use Philicevic\FaceitPhp\Validation\ValidatesFields;

readonly class Tournament
{
    use ValidatesFields;

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

    protected static function fieldSchema(): array
    {
        return [
            'tournament_id' => 'string',
            'name' => 'string',
            'game_id' => '?string',
            'region' => '?string',
            'status' => '?string',
            'faceit_url' => '?string',
            'featured_image' => '?string',
            'cover_image' => '?string',
            'description' => '?string',
            'membership_type' => '?string',
            'match_type' => '?string',
            'prize_type' => '?string',
            'invite_type' => '?string',
            'organizer_id' => '?string',
            'team_size' => '?int',
            'max_skill' => '?int',
            'min_skill' => '?int',
            'number_of_players' => '?int',
            'number_of_players_joined' => '?int',
            'number_of_players_checkedin' => '?int',
            'number_of_players_participants' => '?int',
            'anticheat_required' => '?bool',
            'calculate_elo' => '?bool',
            'custom' => '?bool',
            'started_at' => '?int',
            'whitelist_countries' => '?array',
        ];
    }

    public static function fromArray(array $data): self
    {
        return static::validated($data, fn ($d) => new self(
            uuid: $d['tournament_id'],
            name: $d['name'],
            gameId: (string) ($d['game_id'] ?? ''),
            region: (string) ($d['region'] ?? ''),
            status: (string) ($d['status'] ?? ''),
            faceitUrl: (string) ($d['faceit_url'] ?? ''),
            featuredImage: (string) ($d['featured_image'] ?? ''),
            coverImage: (string) ($d['cover_image'] ?? ''),
            description: (string) ($d['description'] ?? ''),
            membershipType: (string) ($d['membership_type'] ?? ''),
            matchType: (string) ($d['match_type'] ?? ''),
            prizeType: (string) ($d['prize_type'] ?? ''),
            inviteType: (string) ($d['invite_type'] ?? ''),
            organizerId: (string) ($d['organizer_id'] ?? ''),
            teamSize: (int) ($d['team_size'] ?? 0),
            maxSkill: (int) ($d['max_skill'] ?? 0),
            minSkill: (int) ($d['min_skill'] ?? 0),
            numberOfPlayers: (int) ($d['number_of_players'] ?? 0),
            numberOfPlayersJoined: (int) ($d['number_of_players_joined'] ?? 0),
            numberOfPlayersCheckedin: (int) ($d['number_of_players_checkedin'] ?? 0),
            numberOfPlayersParticipants: (int) ($d['number_of_players_participants'] ?? 0),
            anticheatRequired: (bool) ($d['anticheat_required'] ?? false),
            calculateElo: (bool) ($d['calculate_elo'] ?? false),
            custom: (bool) ($d['custom'] ?? false),
            startedAt: new \DateTime('@'.(int) ($d['started_at'] ?? 0)),
            whitelistCountries: $d['whitelist_countries'] ?? [],
        ));
    }
}
