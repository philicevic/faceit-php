<?php

namespace Philicevic\FaceitPhp\Requests;

use Philicevic\FaceitPhp\DTO\Game\Game;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

class GetGameRequest extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        protected readonly string $uuid
    ) {}

    public function resolveEndpoint(): string
    {
        return '/games/'.$this->uuid;
    }

    public function createDtoFromResponse(Response $response): Game
    {
        return Game::fromArray($response->json());
    }
}
