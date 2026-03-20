<?php

namespace Philicevic\FaceitPhp\Requests;

use Philicevic\FaceitPhp\DTO\Player;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

class GetPlayerRequest extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        protected readonly string $uuid
    ) {}

    public function resolveEndpoint(): string
    {
        return '/players/'.$this->uuid;
    }

    public function createDtoFromResponse(Response $response): Player
    {
        return Player::fromArray($response->json());
    }
}
