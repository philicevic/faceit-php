<?php

namespace Philicevic\FaceitPhp\Requests;

use Philicevic\FaceitPhp\DTO\Championship\Championship;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

class GetChampionshipRequest extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        protected readonly string $championshipId,
        protected readonly ?string $expanded = null,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/championships/'.$this->championshipId;
    }

    protected function defaultQuery(): array
    {
        return array_filter([
            'expanded' => $this->expanded,
        ], static fn (mixed $value): bool => $value !== null);
    }

    public function createDtoFromResponse(Response $response): Championship
    {
        return Championship::fromArray($response->json());
    }
}
