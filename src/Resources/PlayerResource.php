<?php

namespace Philicevic\FaceitPhp\Resources;

use Philicevic\FaceitPhp\DTO\Player;
use Philicevic\FaceitPhp\Requests\GetPlayerRequest;
use Saloon\Http\BaseResource;

class PlayerResource extends BaseResource
{
    public function get(string $uuid): Player
    {
        $request = new GetPlayerRequest($uuid);
        $response = $this->connector->send($request);
        return $request->createDtoFromResponse($response);
    }
}