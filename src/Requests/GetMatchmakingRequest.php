<?php

namespace Philicevic\FaceitPhp\Requests;

use Philicevic\FaceitPhp\DTO\Matchmaking\Matchmaking;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

class GetMatchmakingRequest extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        protected readonly string $matchmakingId,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/matchmakings/'.$this->matchmakingId;
    }

    public function createDtoFromResponse(Response $response): Matchmaking
    {
        return Matchmaking::fromArray($response->json());
    }
}
