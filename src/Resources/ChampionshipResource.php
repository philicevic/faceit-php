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
use Saloon\Http\BaseResource;

class ChampionshipResource extends BaseResource
{
    /**
     * @return PaginatedResponse<Championship>
     */
    public function list(string $game, ?string $type = null, int $offset = 0, int $limit = 10): PaginatedResponse
    {
        $request = new GetChampionshipsRequest($game, $type, $offset, $limit);
        $response = $this->connector->send($request);

        return $request->createDtoFromResponse($response);
    }

    public function get(string $championshipId, ?string $expanded = null): Championship
    {
        $request = new GetChampionshipRequest($championshipId, $expanded);
        $response = $this->connector->send($request);

        return $request->createDtoFromResponse($response);
    }

    /**
     * @return PaginatedResponse<Info>
     */
    public function getMatches(string $championshipId, ?string $type = null, int $offset = 0, int $limit = 20): PaginatedResponse
    {
        $request = new GetChampionshipMatchesRequest($championshipId, $type, $offset, $limit);
        $response = $this->connector->send($request);

        return $request->createDtoFromResponse($response);
    }

    /**
     * @return PaginatedResponse<Info>
     */
    public function getResults(string $championshipId, int $offset = 0, int $limit = 20): PaginatedResponse
    {
        $request = new GetChampionshipResultsRequest($championshipId, $offset, $limit);
        $response = $this->connector->send($request);

        return $request->createDtoFromResponse($response);
    }

    /**
     * @return PaginatedResponse<Subscription>
     */
    public function getSubscriptions(string $championshipId, int $offset = 0, int $limit = 10): PaginatedResponse
    {
        $request = new GetChampionshipSubscriptionsRequest($championshipId, $offset, $limit);
        $response = $this->connector->send($request);

        return $request->createDtoFromResponse($response);
    }
}
