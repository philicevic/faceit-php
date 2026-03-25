<?php

namespace Philicevic\FaceitPhp\Requests;

use Philicevic\FaceitPhp\DTO\PaginatedResponse;
use Philicevic\FaceitPhp\DTO\Search\Team;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

class SearchTeamsRequest extends Request
{
    protected Method $method = Method::GET;

    protected const ALLOWED_FILTERS = ['game'];

    public function __construct(
        protected readonly string $searchQuery,
        protected readonly int $offset = 0,
        protected readonly int $limit = 20,
        protected readonly array $filters = [],
    ) {
        $invalid = array_diff(array_keys($filters), self::ALLOWED_FILTERS);
        if ($invalid) {
            throw new \InvalidArgumentException(
                'Invalid filters for team search: '.implode(', ', $invalid)
            );
        }
    }

    public function resolveEndpoint(): string
    {
        return '/search/teams';
    }

    protected function defaultQuery(): array
    {
        return array_filter([
            'nickname' => $this->searchQuery,
            'offset' => $this->offset,
            'limit' => $this->limit,
            'game' => $this->filters['game'] ?? null,
        ], static fn (mixed $value): bool => $value !== null);
    }

    /**
     * @return PaginatedResponse<Team>
     */
    public function createDtoFromResponse(Response $response): PaginatedResponse
    {
        return PaginatedResponse::fromArray($response->json(), Team::fromArray(...));
    }
}
