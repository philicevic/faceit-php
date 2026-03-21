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

class LeaderboardResource extends FaceitResource
{
    /**
     * @return PaginatedResponse<Leaderboard>
     */
    public function getChampionshipLeaderboards(string $championshipId, int $offset = 0, int $limit = 20): PaginatedResponse
    {
        return $this->send(new GetChampionshipLeaderboardsRequest($championshipId, $offset, $limit));
    }

    public function getChampionshipGroupRanking(string $championshipId, int $group, int $offset = 0, int $limit = 20): EntityRanking
    {
        return $this->send(new GetChampionshipGroupRankingRequest($championshipId, $group, $offset, $limit));
    }

    /**
     * @return PaginatedResponse<Leaderboard>
     */
    public function getHubLeaderboards(string $hubId, int $offset = 0, int $limit = 20): PaginatedResponse
    {
        return $this->send(new GetHubLeaderboardsRequest($hubId, $offset, $limit));
    }

    public function getHubRanking(string $hubId, int $offset = 0, int $limit = 20): EntityRanking
    {
        return $this->send(new GetHubRankingRequest($hubId, $offset, $limit));
    }

    public function get(string $leaderboardId, int $offset = 0, int $limit = 20): EntityRanking
    {
        return $this->send(new GetLeaderboardRequest($leaderboardId, $offset, $limit));
    }
}
