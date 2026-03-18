<?php

namespace Philicevic\FaceitPhp\Requests;

use Philicevic\FaceitPhp\DTO\Tournament\Tournament;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

class GetTournamentRequest extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        protected readonly string $tournamentId,
        protected readonly ?string $expanded = null,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/tournaments/'.$this->tournamentId;
    }

    protected function defaultQuery(): array
    {
        return array_filter([
            'expanded' => $this->expanded,
        ], static fn (mixed $value): bool => $value !== null);
    }

    public function createDtoFromResponse(Response $response): Tournament
    {
        $data = $response->json();

        return new Tournament(
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
