<?php

namespace Philicevic\FaceitPhp\Resources;

use Philicevic\FaceitPhp\DTO\Match\Detail\Info;
use Philicevic\FaceitPhp\DTO\Match\Stats\MatchStats;
use Philicevic\FaceitPhp\Requests\GetMatchDetailsRequest;
use Philicevic\FaceitPhp\Requests\GetMatchStatsRequest;

class MatchResource extends FaceitResource
{
    public function get(string $uuid): Info
    {
        return $this->send(new GetMatchDetailsRequest($uuid));
    }

    public function getStats(string $uuid): MatchStats
    {
        return $this->send(new GetMatchStatsRequest($uuid));
    }
}
