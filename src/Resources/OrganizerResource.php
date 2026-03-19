<?php

namespace Philicevic\FaceitPhp\Resources;

use Philicevic\FaceitPhp\DTO\Championship\Championship;
use Philicevic\FaceitPhp\DTO\Game\Game;
use Philicevic\FaceitPhp\DTO\Hub\Hub;
use Philicevic\FaceitPhp\DTO\Organizer\Organizer;
use Philicevic\FaceitPhp\DTO\PaginatedResponse;
use Philicevic\FaceitPhp\DTO\Player\Tournament;
use Philicevic\FaceitPhp\Requests\GetOrganizerByNameRequest;
use Philicevic\FaceitPhp\Requests\GetOrganizerChampionshipsRequest;
use Philicevic\FaceitPhp\Requests\GetOrganizerGamesRequest;
use Philicevic\FaceitPhp\Requests\GetOrganizerHubsRequest;
use Philicevic\FaceitPhp\Requests\GetOrganizerRequest;
use Philicevic\FaceitPhp\Requests\GetOrganizerTournamentsRequest;
use Saloon\Http\BaseResource;

class OrganizerResource extends BaseResource
{
    public function getByName(string $name): Organizer
    {
        $request = new GetOrganizerByNameRequest($name);
        $response = $this->connector->send($request);

        return $request->createDtoFromResponse($response);
    }

    public function get(string $organizerId): Organizer
    {
        $request = new GetOrganizerRequest($organizerId);
        $response = $this->connector->send($request);

        return $request->createDtoFromResponse($response);
    }

    /**
     * @return PaginatedResponse<Championship>
     */
    public function getChampionships(string $organizerId, int $offset = 0, int $limit = 20): PaginatedResponse
    {
        $request = new GetOrganizerChampionshipsRequest($organizerId, $offset, $limit);
        $response = $this->connector->send($request);

        return $request->createDtoFromResponse($response);
    }

    /**
     * @return PaginatedResponse<Game>
     */
    public function getGames(string $organizerId): PaginatedResponse
    {
        $request = new GetOrganizerGamesRequest($organizerId);
        $response = $this->connector->send($request);

        return $request->createDtoFromResponse($response);
    }

    /**
     * @return PaginatedResponse<Hub>
     */
    public function getHubs(string $organizerId, int $offset = 0, int $limit = 20): PaginatedResponse
    {
        $request = new GetOrganizerHubsRequest($organizerId, $offset, $limit);
        $response = $this->connector->send($request);

        return $request->createDtoFromResponse($response);
    }

    /**
     * @return PaginatedResponse<Tournament>
     */
    public function getTournaments(
        string $organizerId,
        ?string $type = null,
        int $offset = 0,
        int $limit = 20,
    ): PaginatedResponse {
        $request = new GetOrganizerTournamentsRequest($organizerId, $type, $offset, $limit);
        $response = $this->connector->send($request);

        return $request->createDtoFromResponse($response);
    }
}
