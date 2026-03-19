<?php

namespace Philicevic\FaceitPhp\Requests;

use Philicevic\FaceitPhp\DTO\Team\Team;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

class GetTeamRequest extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        protected readonly string $teamId,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/teams/'.$this->teamId;
    }

    public function createDtoFromResponse(Response $response): Team
    {
        return Team::fromArray($response->json());
    }
}
