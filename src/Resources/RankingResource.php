<?php

namespace Philicevic\FaceitPhp\Resources;

use Philicevic\FaceitPhp\DTO\PaginatedResponse;
use Philicevic\FaceitPhp\DTO\Ranking\GlobalRankingItem;
use Philicevic\FaceitPhp\Requests\GetGlobalRankingRequest;
use Philicevic\FaceitPhp\Requests\GetPlayerRankingRequest;

class RankingResource extends FaceitResource
{
    /**
     * @return PaginatedResponse<GlobalRankingItem>
     */
    public function getGlobal(string $gameId, string $region, ?string $country = null, int $offset = 0, int $limit = 20): PaginatedResponse
    {
        return $this->send(new GetGlobalRankingRequest($gameId, $region, $country, $offset, $limit));
    }

    /**
     * @return PaginatedResponse<GlobalRankingItem>
     */
    public function getPlayer(string $gameId, string $region, string $playerId, ?string $country = null, int $limit = 20): PaginatedResponse
    {
        return $this->send(new GetPlayerRankingRequest($gameId, $region, $playerId, $country, $limit));
    }
}
