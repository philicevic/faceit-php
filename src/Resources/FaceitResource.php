<?php

namespace Philicevic\FaceitPhp\Resources;

use Saloon\Http\BaseResource;
use Saloon\Http\Request;

abstract class FaceitResource extends BaseResource
{
    protected function send(Request $request): mixed
    {
        return $request->createDtoFromResponse($this->connector->send($request));
    }
}
