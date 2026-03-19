<?php

namespace Philicevic\FaceitPhp\Requests;

use Philicevic\FaceitPhp\DTO\Team\Stats;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

class GetTeamStatsRequest extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        protected readonly string $teamId,
        protected readonly string $gameId,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/teams/'.$this->teamId.'/stats/'.$this->gameId;
    }

    public function createDtoFromResponse(Response $response): Stats
    {
        return Stats::fromArray($response->json());
    }
}
