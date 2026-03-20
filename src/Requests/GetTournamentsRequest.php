<?php

namespace Philicevic\FaceitPhp\Requests;

use Philicevic\FaceitPhp\DTO\PaginatedResponse;
use Philicevic\FaceitPhp\DTO\Player\Tournament;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

class GetTournamentsRequest extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        protected readonly ?string $game = null,
        protected readonly ?string $region = null,
        protected readonly int $offset = 0,
        protected readonly int $limit = 20,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/tournaments';
    }

    protected function defaultQuery(): array
    {
        return array_filter([
            'game' => $this->game,
            'region' => $this->region,
            'offset' => $this->offset,
            'limit' => $this->limit,
        ], static fn (mixed $value): bool => $value !== null);
    }

    /**
     * @return PaginatedResponse<Tournament>
     */
    public function createDtoFromResponse(Response $response): PaginatedResponse
    {
        return PaginatedResponse::fromArray($response->json(), Tournament::fromArray(...));
    }
}
