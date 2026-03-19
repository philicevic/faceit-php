<?php

namespace Philicevic\FaceitPhp\Resources;

use Philicevic\FaceitPhp\DTO\PaginatedResponse;
use Philicevic\FaceitPhp\DTO\Player\Tournament;
use Philicevic\FaceitPhp\DTO\Team\Stats;
use Philicevic\FaceitPhp\DTO\Team\Team;
use Philicevic\FaceitPhp\Requests\GetTeamRequest;
use Philicevic\FaceitPhp\Requests\GetTeamStatsRequest;
use Philicevic\FaceitPhp\Requests\GetTeamTournamentsRequest;
use Saloon\Http\BaseResource;

class TeamResource extends BaseResource
{
    public function get(string $teamId): Team
    {
        $request = new GetTeamRequest($teamId);
        $response = $this->connector->send($request);

        return $request->createDtoFromResponse($response);
    }

    public function getStats(string $teamId, string $gameId): Stats
    {
        $request = new GetTeamStatsRequest($teamId, $gameId);
        $response = $this->connector->send($request);

        return $request->createDtoFromResponse($response);
    }

    /**
     * @return PaginatedResponse<Tournament>
     */
    public function getTournaments(string $teamId, int $offset = 0, int $limit = 20): PaginatedResponse
    {
        $request = new GetTeamTournamentsRequest($teamId, $offset, $limit);
        $response = $this->connector->send($request);

        return $request->createDtoFromResponse($response);
    }
}
