<?php

namespace Philicevic\FaceitPhp\Requests;

use Philicevic\FaceitPhp\DTO\PaginatedResponse;
use Philicevic\FaceitPhp\DTO\Player\Hub;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

class GetPlayerHubsRequest extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        protected readonly string $playerId,
        protected readonly int $offset = 0,
        protected readonly int $limit = 50,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/players/'.$this->playerId.'/hubs';
    }

    protected function defaultQuery(): array
    {
        return [
            'offset' => $this->offset,
            'limit' => $this->limit,
        ];
    }

    /**
     * @return PaginatedResponse<Hub>
     */
    public function createDtoFromResponse(Response $response): PaginatedResponse
    {
        $data = $response->json();

        return new PaginatedResponse(
            items: array_map(fn (array $hub): Hub => Hub::fromArray($hub), $data['items'] ?? []),
            start: $data['start'] ?? 0,
            end: $data['end'] ?? 0,
        );
    }
}
