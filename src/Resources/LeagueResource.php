<?php

namespace Philicevic\FaceitPhp\Resources;

use Philicevic\FaceitPhp\DTO\League\League;
use Philicevic\FaceitPhp\DTO\League\PlayerInLeague;
use Philicevic\FaceitPhp\DTO\League\SeasonDetailed;
use Philicevic\FaceitPhp\Requests\GetLeagueRequest;
use Philicevic\FaceitPhp\Requests\GetLeagueSeasonPlayerRequest;
use Philicevic\FaceitPhp\Requests\GetLeagueSeasonRequest;
use Saloon\Http\BaseResource;

class LeagueResource extends BaseResource
{
    public function get(string $leagueId): League
    {
        $request = new GetLeagueRequest($leagueId);
        $response = $this->connector->send($request);

        return $request->createDtoFromResponse($response);
    }

    public function getSeason(string $leagueId, string $seasonId): SeasonDetailed
    {
        $request = new GetLeagueSeasonRequest($leagueId, $seasonId);
        $response = $this->connector->send($request);

        return $request->createDtoFromResponse($response);
    }

    public function getSeasonPlayer(string $leagueId, string $seasonId, string $playerId): PlayerInLeague
    {
        $request = new GetLeagueSeasonPlayerRequest($leagueId, $seasonId, $playerId);
        $response = $this->connector->send($request);

        return $request->createDtoFromResponse($response);
    }
}
