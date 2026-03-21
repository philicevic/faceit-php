<?php

namespace Philicevic\FaceitPhp\Resources;

use Philicevic\FaceitPhp\DTO\Matchmaking\Matchmaking;
use Philicevic\FaceitPhp\Requests\GetMatchmakingRequest;

class MatchmakingResource extends FaceitResource
{
    public function get(string $matchmakingId): Matchmaking
    {
        return $this->send(new GetMatchmakingRequest($matchmakingId));
    }
}
