<?php

namespace Philicevic\FaceitPhp;

use Philicevic\FaceitPhp\DTO\PaginatedResponse;
use Philicevic\FaceitPhp\Enums\SearchType;
use Philicevic\FaceitPhp\Requests\SearchChampionshipsRequest;
use Philicevic\FaceitPhp\Requests\SearchClansRequest;
use Philicevic\FaceitPhp\Requests\SearchHubsRequest;
use Philicevic\FaceitPhp\Requests\SearchOrganizersRequest;
use Philicevic\FaceitPhp\Requests\SearchPlayersRequest;
use Philicevic\FaceitPhp\Requests\SearchTeamsRequest;
use Philicevic\FaceitPhp\Requests\SearchTournamentsRequest;
use Philicevic\FaceitPhp\Resources\ChampionshipResource;
use Philicevic\FaceitPhp\Resources\GameResource;
use Philicevic\FaceitPhp\Resources\HubResource;
use Philicevic\FaceitPhp\Resources\LeaderboardResource;
use Philicevic\FaceitPhp\Resources\MatchmakingResource;
use Philicevic\FaceitPhp\Resources\MatchResource;
use Philicevic\FaceitPhp\Resources\OrganizerResource;
use Philicevic\FaceitPhp\Resources\PlayerResource;
use Philicevic\FaceitPhp\Resources\RankingResource;
use Philicevic\FaceitPhp\Resources\TeamResource;
use Philicevic\FaceitPhp\Validation\ValidationContext;
use Saloon\Http\Auth\TokenAuthenticator;
use Saloon\Http\Connector;
use Saloon\Traits\Plugins\AlwaysThrowOnErrors;

class Faceit extends Connector
{
    use AlwaysThrowOnErrors;

    public function __construct(public readonly string $token, bool $strict = false)
    {
        if ($strict) {
            ValidationContext::enable();
        } else {
            ValidationContext::disable();
        }
    }

    public function resolveBaseUrl(): string
    {
        return 'https://open.faceit.com/data/v4';
    }

    protected function defaultHeaders(): array
    {
        return [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ];
    }

    protected function defaultAuth(): TokenAuthenticator
    {
        return new TokenAuthenticator($this->token);
    }

    public function championship(): ChampionshipResource
    {
        return new ChampionshipResource($this);
    }

    public function game(): GameResource
    {
        return new GameResource($this);
    }

    public function hub(): HubResource
    {
        return new HubResource($this);
    }

    public function leaderboard(): LeaderboardResource
    {
        return new LeaderboardResource($this);
    }

    public function match(): MatchResource
    {
        return new MatchResource($this);
    }

    public function matchmaking(): MatchmakingResource
    {
        return new MatchmakingResource($this);
    }

    public function organizer(): OrganizerResource
    {
        return new OrganizerResource($this);
    }

    public function player(): PlayerResource
    {
        return new PlayerResource($this);
    }

    public function ranking(): RankingResource
    {
        return new RankingResource($this);
    }

    public function team(): TeamResource
    {
        return new TeamResource($this);
    }

    /**
     * Search across FACEIT entities.
     *
     * Supported $filters keys per type:
     *   Championship: game, region, type
     *   Clan:         game, region
     *   Hub:          game, region
     *   Organizer:    (none)
     *   Player:       game, country
     *   Team:         game
     *   Tournament:   game, region, type
     */
    public function search(
        string $query,
        SearchType $type = SearchType::Player,
        int $offset = 0,
        int $limit = 20,
        array $filters = [],
    ): PaginatedResponse {
        $request = match ($type) {
            SearchType::Championship => new SearchChampionshipsRequest($query, $offset, $limit, $filters),
            SearchType::Clan => new SearchClansRequest($query, $offset, $limit, $filters),
            SearchType::Hub => new SearchHubsRequest($query, $offset, $limit, $filters),
            SearchType::Organizer => new SearchOrganizersRequest($query, $offset, $limit, $filters),
            SearchType::Player => new SearchPlayersRequest($query, $offset, $limit, $filters),
            SearchType::Team => new SearchTeamsRequest($query, $offset, $limit, $filters),
            SearchType::Tournament => new SearchTournamentsRequest($query, $offset, $limit, $filters),
        };

        return $request->createDtoFromResponse($this->send($request));
    }
}
