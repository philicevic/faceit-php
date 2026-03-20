<?php

namespace Philicevic\FaceitPhp\Resources;

use Philicevic\FaceitPhp\DTO\PaginatedResponse;
use Philicevic\FaceitPhp\DTO\Ranking\GlobalRankingItem;
use Philicevic\FaceitPhp\Requests\GetGlobalRankingRequest;
use Philicevic\FaceitPhp\Requests\GetPlayerRankingRequest;
use Saloon\Http\BaseResource;

class RankingResource extends BaseResource
{
    /**
     * @return PaginatedResponse<GlobalRankingItem>
     */
    public function getGlobal(string $gameId, string $region, ?string $country = null, int $offset = 0, int $limit = 20): PaginatedResponse
    {
        $request = new GetGlobalRankingRequest($gameId, $region, $country, $offset, $limit);
        $response = $this->connector->send($request);

        return $request->createDtoFromResponse($response);
    }

    /**
     * @return PaginatedResponse<GlobalRankingItem>
     */
    public function getPlayer(string $gameId, string $region, string $playerId, ?string $country = null, int $limit = 20): PaginatedResponse
    {
        $request = new GetPlayerRankingRequest($gameId, $region, $playerId, $country, $limit);
        $response = $this->connector->send($request);

        return $request->createDtoFromResponse($response);
    }
}
