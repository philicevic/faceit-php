<?php

namespace Philicevic\FaceitPhp\Resources;

use Philicevic\FaceitPhp\DTO\Matchmaking\Matchmaking;
use Philicevic\FaceitPhp\Requests\GetMatchmakingRequest;
use Saloon\Http\BaseResource;

class MatchmakingResource extends BaseResource
{
    public function get(string $matchmakingId): Matchmaking
    {
        $request = new GetMatchmakingRequest($matchmakingId);
        $response = $this->connector->send($request);

        return $request->createDtoFromResponse($response);
    }
}
