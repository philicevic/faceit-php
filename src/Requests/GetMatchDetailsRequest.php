<?php

namespace Philicevic\FaceitPhp\Requests;

use Philicevic\FaceitPhp\DTO\Match\Detail\Info;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

class GetMatchDetailsRequest extends Request
{
    public function __construct(protected readonly string $uuid) {}

    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return '/matches/'.$this->uuid;
    }

    public function createDtoFromResponse(Response $response): Info
    {
        return Info::fromArray($response->json());
    }
}
