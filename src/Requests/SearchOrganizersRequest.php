<?php

namespace Philicevic\FaceitPhp\Requests;

use Philicevic\FaceitPhp\DTO\PaginatedResponse;
use Philicevic\FaceitPhp\DTO\Search\Organizer;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

class SearchOrganizersRequest extends Request
{
    protected Method $method = Method::GET;

    protected const ALLOWED_FILTERS = [];

    public function __construct(
        protected readonly string $searchQuery,
        protected readonly int $offset = 0,
        protected readonly int $limit = 20,
        protected readonly array $filters = [],
    ) {
        $invalid = array_diff(array_keys($filters), self::ALLOWED_FILTERS);
        if ($invalid) {
            throw new \InvalidArgumentException(
                'Invalid filters for organizer search: '.implode(', ', $invalid)
            );
        }
    }

    public function resolveEndpoint(): string
    {
        return '/search/organizers';
    }

    protected function defaultQuery(): array
    {
        return [
            'name' => $this->searchQuery,
            'offset' => $this->offset,
            'limit' => $this->limit,
        ];
    }

    /**
     * @return PaginatedResponse<Organizer>
     */
    public function createDtoFromResponse(Response $response): PaginatedResponse
    {
        return PaginatedResponse::fromArray($response->json(), Organizer::fromArray(...));
    }
}
