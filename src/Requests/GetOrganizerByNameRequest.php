<?php

namespace Philicevic\FaceitPhp\Requests;

use Philicevic\FaceitPhp\DTO\Organizer\Organizer;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

class GetOrganizerByNameRequest extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        protected readonly string $name,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/organizers';
    }

    protected function defaultQuery(): array
    {
        return ['name' => $this->name];
    }

    public function createDtoFromResponse(Response $response): Organizer
    {
        return Organizer::fromArray($response->json());
    }
}
