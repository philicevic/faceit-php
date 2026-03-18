<?php

namespace Philicevic\FaceitPhp\Requests;

use Philicevic\FaceitPhp\DTO\PaginatedResponse;
use Philicevic\FaceitPhp\DTO\Player\Tournament;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

class GetPlayerTournamentsRequest extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        protected readonly string $playerId,
        protected readonly int $offset = 0,
        protected readonly int $limit = 20,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/players/'.$this->playerId.'/tournaments';
    }

    protected function defaultQuery(): array
    {
        return [
            'offset' => $this->offset,
            'limit' => $this->limit,
        ];
    }

    /**
     * @return PaginatedResponse<Tournament>
     */
    public function createDtoFromResponse(Response $response): PaginatedResponse
    {
        $data = $response->json();
        $items = array_map(function (array $tournament): Tournament {
            return new Tournament(
                uuid: $tournament['tournament_id'],
                name: $tournament['name'],
                gameId: (string) ($tournament['game_id'] ?? ''),
                region: (string) ($tournament['region'] ?? ''),
                status: (string) ($tournament['status'] ?? ''),
                faceitUrl: (string) ($tournament['faceit_url'] ?? ''),
                featuredImage: (string) ($tournament['featured_image'] ?? ''),
                membershipType: (string) ($tournament['membership_type'] ?? ''),
                matchType: (string) ($tournament['match_type'] ?? ''),
                prizeType: (string) ($tournament['prize_type'] ?? ''),
                teamSize: (int) ($tournament['team_size'] ?? 0),
                maxSkill: (int) ($tournament['max_skill'] ?? 0),
                minSkill: (int) ($tournament['min_skill'] ?? 0),
                subscriptionsCount: (int) ($tournament['subscriptions_count'] ?? 0),
                numberOfPlayers: (int) ($tournament['number_of_players'] ?? 0),
                numberOfPlayersJoined: (int) ($tournament['number_of_players_joined'] ?? 0),
                numberOfPlayersCheckedin: (int) ($tournament['number_of_players_checkedin'] ?? 0),
                numberOfPlayersParticipants: (int) ($tournament['number_of_players_participants'] ?? 0),
                startedAt: new \DateTime('@'.(int) ($tournament['started_at'] ?? 0)),
                whitelistCountries: $tournament['whitelist_countries'] ?? [],
            );
        }, $data['items'] ?? []);

        return new PaginatedResponse(
            items: $items,
            start: $data['start'] ?? 0,
            end: $data['end'] ?? 0,
        );
    }
}
