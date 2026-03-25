<?php

namespace Philicevic\FaceitPhp\Requests;

use Philicevic\FaceitPhp\DTO\Game\Game;
use Philicevic\FaceitPhp\DTO\PaginatedResponse;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

class GetOrganizerGamesRequest extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        protected readonly string $organizerId,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/organizers/'.$this->organizerId.'/games';
    }

    /**
     * @return PaginatedResponse<Game>
     */
    public function createDtoFromResponse(Response $response): PaginatedResponse
    {
        return PaginatedResponse::fromArray($response->json(), Game::fromArray(...));
    }
}
