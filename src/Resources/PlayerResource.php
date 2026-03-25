<?php

namespace Philicevic\FaceitPhp\Resources;

use Philicevic\FaceitPhp\DTO\Ban;
use Philicevic\FaceitPhp\DTO\Match\Summary\Info;
use Philicevic\FaceitPhp\DTO\PaginatedResponse;
use Philicevic\FaceitPhp\DTO\Player;
use Philicevic\FaceitPhp\DTO\Player\GameMatchStats;
use Philicevic\FaceitPhp\DTO\Player\Hub;
use Philicevic\FaceitPhp\DTO\Player\LifetimeStats;
use Philicevic\FaceitPhp\DTO\Team\Team;
use Philicevic\FaceitPhp\DTO\Tournament;
use Philicevic\FaceitPhp\Requests\GetPlayerBansRequest;
use Philicevic\FaceitPhp\Requests\GetPlayerGameStatsRequest;
use Philicevic\FaceitPhp\Requests\GetPlayerHubsRequest;
use Philicevic\FaceitPhp\Requests\GetPlayerLifetimeStatsRequest;
use Philicevic\FaceitPhp\Requests\GetPlayerLookupRequest;
use Philicevic\FaceitPhp\Requests\GetPlayerMatchesRequest;
use Philicevic\FaceitPhp\Requests\GetPlayerRequest;
use Philicevic\FaceitPhp\Requests\GetPlayerTeamsRequest;
use Philicevic\FaceitPhp\Requests\GetPlayerTournamentsRequest;

class PlayerResource extends FaceitResource
{
    public function get(string $uuid): Player
    {
        return $this->send(new GetPlayerRequest($uuid));
    }

    public function lookup(?string $nickname = null, ?string $game = null, ?string $gamePlayerId = null): Player
    {
        return $this->send(new GetPlayerLookupRequest($nickname, $game, $gamePlayerId));
    }

    /**
     * @return PaginatedResponse<Ban>
     */
    public function getBans(string $playerId, int $offset = 0, int $limit = 20): PaginatedResponse
    {
        return $this->send(new GetPlayerBansRequest($playerId, $offset, $limit));
    }

    /**
     * @return PaginatedResponse<GameMatchStats>
     */
    public function getGameStats(string $playerId, string $gameId, int $offset = 0, int $limit = 20, ?int $from = null, ?int $to = null): PaginatedResponse
    {
        return $this->send(new GetPlayerGameStatsRequest($playerId, $gameId, $offset, $limit, $from, $to));
    }

    /**
     * @return PaginatedResponse<Info>
     */
    public function getMatches(string $playerId, string $game, ?int $from = null, ?int $to = null, int $offset = 0, int $limit = 20): PaginatedResponse
    {
        return $this->send(new GetPlayerMatchesRequest($playerId, $game, $from, $to, $offset, $limit));
    }

    /**
     * @return PaginatedResponse<Hub>
     */
    public function getHubs(string $playerId, int $offset = 0, int $limit = 50): PaginatedResponse
    {
        return $this->send(new GetPlayerHubsRequest($playerId, $offset, $limit));
    }

    public function getStats(string $playerId, string $gameId): LifetimeStats
    {
        return $this->send(new GetPlayerLifetimeStatsRequest($playerId, $gameId));
    }

    /**
     * @return PaginatedResponse<Team>
     */
    public function getTeams(string $playerId, int $offset = 0, int $limit = 20): PaginatedResponse
    {
        return $this->send(new GetPlayerTeamsRequest($playerId, $offset, $limit));
    }

    /**
     * @return PaginatedResponse<Tournament>
     */
    public function getTournaments(string $playerId, int $offset = 0, int $limit = 20): PaginatedResponse
    {
        return $this->send(new GetPlayerTournamentsRequest($playerId, $offset, $limit));
    }
}
