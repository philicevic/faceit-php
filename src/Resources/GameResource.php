<?php

namespace Philicevic\FaceitPhp\Resources;

use Philicevic\FaceitPhp\DTO\Game\Game;
use Philicevic\FaceitPhp\DTO\Game\MatchmakingSummary;
use Philicevic\FaceitPhp\DTO\PaginatedResponse;
use Philicevic\FaceitPhp\Requests\GetGameMatchmakingsRequest;
use Philicevic\FaceitPhp\Requests\GetGameRequest;
use Philicevic\FaceitPhp\Requests\GetGamesRequest;
use Saloon\Http\BaseResource;

class GameResource extends BaseResource
{
    /**
     * @return PaginatedResponse<Game>
     */
    public function list(int $offset = 0, int $limit = 20): PaginatedResponse
    {
        $request = new GetGamesRequest($offset, $limit);
        $response = $this->connector->send($request);

        return $request->createDtoFromResponse($response);
    }

    public function get(string $gameId): Game
    {
        $request = new GetGameRequest($gameId);
        $response = $this->connector->send($request);

        return $request->createDtoFromResponse($response);
    }

    /**
     * @return PaginatedResponse<MatchmakingSummary>
     */
    public function getMatchmakings(string $gameId, ?string $region = null, int $offset = 0, int $limit = 20): PaginatedResponse
    {
        $request = new GetGameMatchmakingsRequest($gameId, $region, $offset, $limit);
        $response = $this->connector->send($request);

        return $request->createDtoFromResponse($response);
    }
}
