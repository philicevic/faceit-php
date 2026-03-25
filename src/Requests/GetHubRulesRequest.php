<?php

namespace Philicevic\FaceitPhp\Requests;

use Philicevic\FaceitPhp\DTO\Hub\Rules;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

class GetHubRulesRequest extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        protected readonly string $hubId,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/hubs/'.$this->hubId.'/rules';
    }

    public function createDtoFromResponse(Response $response): Rules
    {
        return Rules::fromArray($response->json());
    }
}
