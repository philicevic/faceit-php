<?php

namespace Philicevic\FaceitPhp\Resources;

use Philicevic\FaceitPhp\DTO\Leaderboard\EntityRanking;
use Philicevic\FaceitPhp\DTO\Leaderboard\Leaderboard;
use Philicevic\FaceitPhp\DTO\PaginatedResponse;
use Philicevic\FaceitPhp\Requests\GetChampionshipGroupRankingRequest;
use Philicevic\FaceitPhp\Requests\GetChampionshipLeaderboardsRequest;
use Philicevic\FaceitPhp\Requests\GetHubLeaderboardsRequest;
use Philicevic\FaceitPhp\Requests\GetHubRankingRequest;
use Philicevic\FaceitPhp\Requests\GetLeaderboardRequest;
use Saloon\Http\BaseResource;

class LeaderboardResource extends BaseResource
{
    /**
     * @return PaginatedResponse<Leaderboard>
     */
    public function getChampionshipLeaderboards(string $championshipId, int $offset = 0, int $limit = 20): PaginatedResponse
    {
        $request = new GetChampionshipLeaderboardsRequest($championshipId, $offset, $limit);
        $response = $this->connector->send($request);

        return $request->createDtoFromResponse($response);
    }

    public function getChampionshipGroupRanking(string $championshipId, int $group, int $offset = 0, int $limit = 20): EntityRanking
    {
        $request = new GetChampionshipGroupRankingRequest($championshipId, $group, $offset, $limit);
        $response = $this->connector->send($request);

        return $request->createDtoFromResponse($response);
    }

    /**
     * @return PaginatedResponse<Leaderboard>
     */
    public function getHubLeaderboards(string $hubId, int $offset = 0, int $limit = 20): PaginatedResponse
    {
        $request = new GetHubLeaderboardsRequest($hubId, $offset, $limit);
        $response = $this->connector->send($request);

        return $request->createDtoFromResponse($response);
    }

    public function getHubRanking(string $hubId, int $offset = 0, int $limit = 20): EntityRanking
    {
        $request = new GetHubRankingRequest($hubId, $offset, $limit);
        $response = $this->connector->send($request);

        return $request->createDtoFromResponse($response);
    }

    public function get(string $leaderboardId, int $offset = 0, int $limit = 20): EntityRanking
    {
        $request = new GetLeaderboardRequest($leaderboardId, $offset, $limit);
        $response = $this->connector->send($request);

        return $request->createDtoFromResponse($response);
    }
}
