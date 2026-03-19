<?php

namespace Philicevic\FaceitPhp\Requests;

use Philicevic\FaceitPhp\DTO\Game\Game;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

class GetParentGameRequest extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        protected readonly string $gameId,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/games/'.$this->gameId.'/parent';
    }

    public function createDtoFromResponse(Response $response): Game
    {
        return Game::fromArray($response->json());
    }
}
