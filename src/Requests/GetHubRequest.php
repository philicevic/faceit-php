<?php

namespace Philicevic\FaceitPhp\Requests;

use Philicevic\FaceitPhp\DTO\Hub\Hub;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

class GetHubRequest extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        protected readonly string $hubId,
        protected readonly ?string $expanded = null,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/hubs/'.$this->hubId;
    }

    protected function defaultQuery(): array
    {
        return array_filter([
            'expanded' => $this->expanded,
        ], static fn (mixed $value): bool => $value !== null);
    }

    public function createDtoFromResponse(Response $response): Hub
    {
        return Hub::fromArray($response->json());
    }
}
