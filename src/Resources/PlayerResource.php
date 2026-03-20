<?php

namespace Philicevic\FaceitPhp\Resources;

use Philicevic\FaceitPhp\DTO\Ban;
use Philicevic\FaceitPhp\DTO\Match\Summary\Info;
use Philicevic\FaceitPhp\DTO\PaginatedResponse;
use Philicevic\FaceitPhp\DTO\Player;
use Philicevic\FaceitPhp\DTO\Player\GameMatchStats;
use Philicevic\FaceitPhp\DTO\Player\Hub;
use Philicevic\FaceitPhp\DTO\Player\LifetimeStats;
use Philicevic\FaceitPhp\DTO\Player\Tournament;
use Philicevic\FaceitPhp\DTO\Team\Team;
use Philicevic\FaceitPhp\Requests\GetPlayerBansRequest;
use Philicevic\FaceitPhp\Requests\GetPlayerGameStatsRequest;
use Philicevic\FaceitPhp\Requests\GetPlayerHubsRequest;
use Philicevic\FaceitPhp\Requests\GetPlayerLifetimeStatsRequest;
use Philicevic\FaceitPhp\Requests\GetPlayerLookupRequest;
use Philicevic\FaceitPhp\Requests\GetPlayerMatchesRequest;
use Philicevic\FaceitPhp\Requests\GetPlayerRequest;
use Philicevic\FaceitPhp\Requests\GetPlayerTeamsRequest;
use Philicevic\FaceitPhp\Requests\GetPlayerTournamentsRequest;
use Saloon\Http\BaseResource;

class PlayerResource extends BaseResource
{
    public function get(string $uuid): Player
    {
        $request = new GetPlayerRequest($uuid);
        $response = $this->connector->send($request);

        return $request->createDtoFromResponse($response);
    }

    public function lookup(?string $nickname = null, ?string $game = null, ?string $gamePlayerId = null): Player
    {
        $request = new GetPlayerLookupRequest($nickname, $game, $gamePlayerId);
        $response = $this->connector->send($request);

        return $request->createDtoFromResponse($response);
    }

    /**
     * @return PaginatedResponse<Ban>
     */
    public function getBans(string $playerId, int $offset = 0, int $limit = 20): PaginatedResponse
    {
        $request = new GetPlayerBansRequest($playerId, $offset, $limit);
        $response = $this->connector->send($request);

        return $request->createDtoFromResponse($response);
    }

    /**
     * @return PaginatedResponse<GameMatchStats>
     */
    public function getGameStats(string $playerId, string $gameId, int $offset = 0, int $limit = 20, ?int $from = null, ?int $to = null): PaginatedResponse
    {
        $request = new GetPlayerGameStatsRequest($playerId, $gameId, $offset, $limit, $from, $to);
        $response = $this->connector->send($request);

        return $request->createDtoFromResponse($response);
    }

    /**
     * @return PaginatedResponse<Info>
     */
    public function getMatches(string $playerId, string $game, ?int $from = null, ?int $to = null, int $offset = 0, int $limit = 20): PaginatedResponse
    {
        $request = new GetPlayerMatchesRequest($playerId, $game, $from, $to, $offset, $limit);
        $response = $this->connector->send($request);

        return $request->createDtoFromResponse($response);
    }

    /**
     * @return PaginatedResponse<Hub>
     */
    public function getHubs(string $playerId, int $offset = 0, int $limit = 50): PaginatedResponse
    {
        $request = new GetPlayerHubsRequest($playerId, $offset, $limit);
        $response = $this->connector->send($request);

        return $request->createDtoFromResponse($response);
    }

    public function getStats(string $playerId, string $gameId): LifetimeStats
    {
        $request = new GetPlayerLifetimeStatsRequest($playerId, $gameId);
        $response = $this->connector->send($request);

        return $request->createDtoFromResponse($response);
    }

    /**
     * @return PaginatedResponse<Team>
     */
    public function getTeams(string $playerId, int $offset = 0, int $limit = 20): PaginatedResponse
    {
        $request = new GetPlayerTeamsRequest($playerId, $offset, $limit);
        $response = $this->connector->send($request);

        return $request->createDtoFromResponse($response);
    }

    /**
     * @return PaginatedResponse<Tournament>
     */
    public function getTournaments(string $playerId, int $offset = 0, int $limit = 20): PaginatedResponse
    {
        $request = new GetPlayerTournamentsRequest($playerId, $offset, $limit);
        $response = $this->connector->send($request);

        return $request->createDtoFromResponse($response);
    }
}
