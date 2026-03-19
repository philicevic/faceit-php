<?php

namespace Philicevic\FaceitPhp\Requests;

use Philicevic\FaceitPhp\DTO\Organizer\Organizer;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

class GetOrganizerRequest extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        protected readonly string $organizerId,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/organizers/'.$this->organizerId;
    }

    public function createDtoFromResponse(Response $response): Organizer
    {
        return Organizer::fromArray($response->json());
    }
}
