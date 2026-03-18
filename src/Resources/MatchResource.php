<?php

namespace Philicevic\FaceitPhp\Resources;

use Philicevic\FaceitPhp\DTO\Match\Detail\Info;
use Philicevic\FaceitPhp\DTO\Match\Stats\MatchStats;
use Philicevic\FaceitPhp\Requests\GetMatchDetailsRequest;
use Philicevic\FaceitPhp\Requests\GetMatchStatsRequest;
use Saloon\Http\BaseResource;

class MatchResource extends BaseResource
{
    public function get(string $uuid): Info
    {
        $request = new GetMatchDetailsRequest($uuid);
        $response = $this->connector->send($request);

        return $request->createDtoFromResponse($response);
    }

    public function getStats(string $uuid): MatchStats
    {
        $request = new GetMatchStatsRequest($uuid);
        $response = $this->connector->send($request);

        return $request->createDtoFromResponse($response);
    }
}
