<?php

namespace Philicevic\FaceitPhp\Resources;

use Philicevic\FaceitPhp\DTO\PaginatedResponse;
use Philicevic\FaceitPhp\DTO\Team\Team;
use Philicevic\FaceitPhp\DTO\Team\TeamStats;
use Philicevic\FaceitPhp\DTO\Tournament;
use Philicevic\FaceitPhp\Requests\GetTeamRequest;
use Philicevic\FaceitPhp\Requests\GetTeamStatsRequest;
use Philicevic\FaceitPhp\Requests\GetTeamTournamentsRequest;

class TeamResource extends FaceitResource
{
    public function get(string $teamId): Team
    {
        return $this->send(new GetTeamRequest($teamId));
    }

    public function getStats(string $teamId, string $gameId): TeamStats
    {
        return $this->send(new GetTeamStatsRequest($teamId, $gameId));
    }

    /**
     * @return PaginatedResponse<Tournament>
     */
    public function getTournaments(string $teamId, int $offset = 0, int $limit = 20): PaginatedResponse
    {
        return $this->send(new GetTeamTournamentsRequest($teamId, $offset, $limit));
    }
}
