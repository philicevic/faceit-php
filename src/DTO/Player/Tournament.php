<?php

namespace Philicevic\FaceitPhp\DTO\Player;

use Philicevic\FaceitPhp\Validation\ValidatesFields;
use Philicevic\FaceitPhp\Validation\ValidationContext;

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
            'membership_type' => '?string',
            'match_type' => '?string',
            'prize_type' => '?string',
            'team_size' => '?int',
            'max_skill' => '?int',
            'min_skill' => '?int',
            'subscriptions_count' => '?int',
            'number_of_players' => '?int',
            'number_of_players_joined' => '?int',
            'number_of_players_checkedin' => '?int',
            'number_of_players_participants' => '?int',
            'started_at' => '?int',
            'whitelist_countries' => '?array',
        ];
    }

    public static function fromArray(array $data): self
    {
        ValidationContext::pushPath('PlayerTournament');
        try {
            static::validateData($data);

            return new self(
                uuid: $data['tournament_id'],
                name: $data['name'],
                gameId: (string) ($data['game_id'] ?? ''),
                region: (string) ($data['region'] ?? ''),
                status: (string) ($data['status'] ?? ''),
                faceitUrl: (string) ($data['faceit_url'] ?? ''),
                featuredImage: (string) ($data['featured_image'] ?? ''),
                membershipType: (string) ($data['membership_type'] ?? ''),
                matchType: (string) ($data['match_type'] ?? ''),
                prizeType: (string) ($data['prize_type'] ?? ''),
                teamSize: (int) ($data['team_size'] ?? 0),
                maxSkill: (int) ($data['max_skill'] ?? 0),
                minSkill: (int) ($data['min_skill'] ?? 0),
                subscriptionsCount: (int) ($data['subscriptions_count'] ?? 0),
                numberOfPlayers: (int) ($data['number_of_players'] ?? 0),
                numberOfPlayersJoined: (int) ($data['number_of_players_joined'] ?? 0),
                numberOfPlayersCheckedin: (int) ($data['number_of_players_checkedin'] ?? 0),
                numberOfPlayersParticipants: (int) ($data['number_of_players_participants'] ?? 0),
                startedAt: new \DateTime('@'.(int) ($data['started_at'] ?? 0)),
                whitelistCountries: $data['whitelist_countries'] ?? [],
            );
        } finally {
            ValidationContext::popPath();
        }
    }
}
