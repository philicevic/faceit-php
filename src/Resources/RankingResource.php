<?php

namespace Philicevic\FaceitPhp\Resources;

use Philicevic\FaceitPhp\DTO\PaginatedResponse;
use Philicevic\FaceitPhp\DTO\Ranking\GlobalRanking;
use Philicevic\FaceitPhp\DTO\Ranking\PlayerRanking;
use Philicevic\FaceitPhp\Requests\GetGlobalRankingRequest;
use Philicevic\FaceitPhp\Requests\GetPlayerRankingRequest;
use Saloon\Http\BaseResource;

class RankingResource extends BaseResource
{
    /**
     * @return PaginatedResponse<GlobalRanking>
     */
    public function getGlobal(
        string $gameId,
        string $region,
        ?string $country = null,
        int $offset = 0,
        int $limit = 20,
    ): PaginatedResponse {
        $request = new GetGlobalRankingRequest($gameId, $region, $country, $offset, $limit);
        $response = $this->connector->send($request);

        return $request->createDtoFromResponse($response);
    }

    public function getPlayer(
        string $gameId,
        string $region,
        string $playerId,
        ?string $country = null,
        int $limit = 20,
    ): PlayerRanking {
        $request = new GetPlayerRankingRequest($gameId, $region, $playerId, $country, $limit);
        $response = $this->connector->send($request);

        return $request->createDtoFromResponse($response);
    }
}
