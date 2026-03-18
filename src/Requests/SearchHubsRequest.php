<?php

namespace Philicevic\FaceitPhp\Requests;

use Philicevic\FaceitPhp\DTO\PaginatedResponse;
use Philicevic\FaceitPhp\DTO\Search\Hub;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

class SearchHubsRequest extends Request
{
    protected Method $method = Method::GET;

    protected const ALLOWED_FILTERS = ['game', 'region'];

    public function __construct(
        protected readonly string $searchQuery,
        protected readonly int $offset = 0,
        protected readonly int $limit = 20,
        protected readonly array $filters = [],
    ) {
        $invalid = array_diff(array_keys($filters), self::ALLOWED_FILTERS);
        if ($invalid) {
            throw new \InvalidArgumentException(
                'Invalid filters for hub search: '.implode(', ', $invalid)
            );
        }
    }

    public function resolveEndpoint(): string
    {
        return '/search/hubs';
    }

    protected function defaultQuery(): array
    {
        return array_filter([
            'name' => $this->searchQuery,
            'offset' => $this->offset,
            'limit' => $this->limit,
            'game' => $this->filters['game'] ?? null,
            'region' => $this->filters['region'] ?? null,
        ], static fn (mixed $value): bool => $value !== null);
    }

    /**
     * @return PaginatedResponse<Hub>
     */
    public function createDtoFromResponse(Response $response): PaginatedResponse
    {
        $data = $response->json();
        $items = array_map(fn (array $item): Hub => new Hub(
            hubId: $item['competition_id'],
            name: $item['name'],
            game: (string) ($item['game'] ?? ''),
            region: (string) ($item['region'] ?? ''),
            status: (string) ($item['status'] ?? ''),
            slots: (int) ($item['slots'] ?? 0),
        ), $data['items'] ?? []);

        return new PaginatedResponse(
            items: $items,
            start: $data['start'] ?? 0,
            end: $data['end'] ?? 0,
        );
    }
}
