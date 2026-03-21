<?php

namespace Philicevic\FaceitPhp\Resources;

use Philicevic\FaceitPhp\DTO\Championship\Championship;
use Philicevic\FaceitPhp\DTO\Organizer\Organizer;
use Philicevic\FaceitPhp\DTO\PaginatedResponse;
use Philicevic\FaceitPhp\DTO\Player\Hub;
use Philicevic\FaceitPhp\DTO\Player\Tournament;
use Philicevic\FaceitPhp\Requests\GetOrganizerByNameRequest;
use Philicevic\FaceitPhp\Requests\GetOrganizerChampionshipsRequest;
use Philicevic\FaceitPhp\Requests\GetOrganizerGamesRequest;
use Philicevic\FaceitPhp\Requests\GetOrganizerHubsRequest;
use Philicevic\FaceitPhp\Requests\GetOrganizerRequest;
use Philicevic\FaceitPhp\Requests\GetOrganizerTournamentsRequest;

class OrganizerResource extends FaceitResource
{
    public function getByName(string $name): Organizer
    {
        return $this->send(new GetOrganizerByNameRequest($name));
    }

    public function get(string $organizerId): Organizer
    {
        return $this->send(new GetOrganizerRequest($organizerId));
    }

    /**
     * @return PaginatedResponse<Championship>
     */
    public function getChampionships(string $organizerId, ?bool $publishedOnly = null, int $offset = 0, int $limit = 20, ?string $sort = null): PaginatedResponse
    {
        return $this->send(new GetOrganizerChampionshipsRequest($organizerId, $publishedOnly, $offset, $limit, $sort));
    }

    /**
     * @return array<string>
     */
    public function getGames(string $organizerId): array
    {
        return $this->send(new GetOrganizerGamesRequest($organizerId));
    }

    /**
     * @return PaginatedResponse<Hub>
     */
    public function getHubs(string $organizerId, int $offset = 0, int $limit = 20): PaginatedResponse
    {
        return $this->send(new GetOrganizerHubsRequest($organizerId, $offset, $limit));
    }

    /**
     * @return PaginatedResponse<Tournament>
     */
    public function getTournaments(string $organizerId, ?string $type = null, int $offset = 0, int $limit = 20): PaginatedResponse
    {
        return $this->send(new GetOrganizerTournamentsRequest($organizerId, $type, $offset, $limit));
    }
}
