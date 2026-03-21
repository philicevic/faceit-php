<?php

namespace Philicevic\FaceitPhp\Resources;

use Philicevic\FaceitPhp\DTO\Championship\Championship;
use Philicevic\FaceitPhp\DTO\Championship\Subscription;
use Philicevic\FaceitPhp\DTO\Match\Detail\Info;
use Philicevic\FaceitPhp\DTO\PaginatedResponse;
use Philicevic\FaceitPhp\Requests\GetChampionshipMatchesRequest;
use Philicevic\FaceitPhp\Requests\GetChampionshipRequest;
use Philicevic\FaceitPhp\Requests\GetChampionshipResultsRequest;
use Philicevic\FaceitPhp\Requests\GetChampionshipsRequest;
use Philicevic\FaceitPhp\Requests\GetChampionshipSubscriptionsRequest;

class ChampionshipResource extends FaceitResource
{
    /**
     * @return PaginatedResponse<Championship>
     */
    public function list(string $game, ?string $type = null, int $offset = 0, int $limit = 10): PaginatedResponse
    {
        return $this->send(new GetChampionshipsRequest($game, $type, $offset, $limit));
    }

    public function get(string $championshipId, ?string $expanded = null): Championship
    {
        return $this->send(new GetChampionshipRequest($championshipId, $expanded));
    }

    /**
     * @return PaginatedResponse<Info>
     */
    public function getMatches(string $championshipId, ?string $type = null, int $offset = 0, int $limit = 20): PaginatedResponse
    {
        return $this->send(new GetChampionshipMatchesRequest($championshipId, $type, $offset, $limit));
    }

    /**
     * @return PaginatedResponse<Info>
     */
    public function getResults(string $championshipId, int $offset = 0, int $limit = 20): PaginatedResponse
    {
        return $this->send(new GetChampionshipResultsRequest($championshipId, $offset, $limit));
    }

    /**
     * @return PaginatedResponse<Subscription>
     */
    public function getSubscriptions(string $championshipId, int $offset = 0, int $limit = 10): PaginatedResponse
    {
        return $this->send(new GetChampionshipSubscriptionsRequest($championshipId, $offset, $limit));
    }
}
