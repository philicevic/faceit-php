<?php

namespace Philicevic\FaceitPhp\Resources;

use Philicevic\FaceitPhp\DTO\MatchInfo;
use Philicevic\FaceitPhp\Requests\GetMatchDetailsRequest;
use Saloon\Http\BaseResource;

class MatchResource extends BaseResource
{
    public function get(string $uuid): MatchInfo
    {
        $request = new GetMatchDetailsRequest($uuid);
        $response = $this->connector->send($request);
        return $request->createDtoFromResponse($response);
    }

    public function getStats(string $uuid)
    {
        // ..
    }
}