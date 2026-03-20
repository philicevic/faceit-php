<?php

namespace Philicevic\FaceitPhp\Requests;

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
     * @return array<string>
     */
    public function createDtoFromResponse(Response $response): array
    {
        return $response->json()['items'] ?? [];
    }
}
