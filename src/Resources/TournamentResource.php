<?php

namespace Philicevic\FaceitPhp\Resources;

use Philicevic\FaceitPhp\DTO\Match\Detail\Info;
use Philicevic\FaceitPhp\DTO\PaginatedResponse;
use Philicevic\FaceitPhp\DTO\Player\Tournament as TournamentSimple;
use Philicevic\FaceitPhp\DTO\Tournament\Brackets;
use Philicevic\FaceitPhp\DTO\Tournament\Teams;
use Philicevic\FaceitPhp\DTO\Tournament\Tournament;
use Philicevic\FaceitPhp\Requests\GetTournamentBracketsRequest;
use Philicevic\FaceitPhp\Requests\GetTournamentMatchesRequest;
use Philicevic\FaceitPhp\Requests\GetTournamentRequest;
use Philicevic\FaceitPhp\Requests\GetTournamentsRequest;
use Philicevic\FaceitPhp\Requests\GetTournamentTeamsRequest;
use Saloon\Http\BaseResource;

class TournamentResource extends BaseResource
{
    /**
     * @return PaginatedResponse<TournamentSimple>
     */
    public function list(?string $game = null, ?string $region = null, int $offset = 0, int $limit = 20): PaginatedResponse
    {
        $request = new GetTournamentsRequest($game, $region, $offset, $limit);
        $response = $this->connector->send($request);

        return $request->createDtoFromResponse($response);
    }

    public function get(string $tournamentId, ?string $expanded = null): Tournament
    {
        $request = new GetTournamentRequest($tournamentId, $expanded);
        $response = $this->connector->send($request);

        return $request->createDtoFromResponse($response);
    }

    public function getBrackets(string $tournamentId): Brackets
    {
        $request = new GetTournamentBracketsRequest($tournamentId);
        $response = $this->connector->send($request);

        return $request->createDtoFromResponse($response);
    }

    /**
     * @return PaginatedResponse<Info>
     */
    public function getMatches(string $tournamentId, int $offset = 0, int $limit = 20): PaginatedResponse
    {
        $request = new GetTournamentMatchesRequest($tournamentId, $offset, $limit);
        $response = $this->connector->send($request);

        return $request->createDtoFromResponse($response);
    }

    public function getTeams(string $tournamentId, int $offset = 0, int $limit = 20): Teams
    {
        $request = new GetTournamentTeamsRequest($tournamentId, $offset, $limit);
        $response = $this->connector->send($request);

        return $request->createDtoFromResponse($response);
    }
}
