<?php

namespace Philicevic\FaceitPhp\Requests;

use Philicevic\FaceitPhp\DTO\PaginatedResponse;
use Philicevic\FaceitPhp\DTO\Search\Player;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

class SearchPlayersRequest extends Request
{
    protected Method $method = Method::GET;

    protected const ALLOWED_FILTERS = ['game', 'country'];

    public function __construct(
        protected readonly string $searchQuery,
        protected readonly int $offset = 0,
        protected readonly int $limit = 20,
        protected readonly array $filters = [],
    ) {
        $invalid = array_diff(array_keys($filters), self::ALLOWED_FILTERS);
        if ($invalid) {
            throw new \InvalidArgumentException(
                'Invalid filters for player search: '.implode(', ', $invalid)
            );
        }
    }

    public function resolveEndpoint(): string
    {
        return '/search/players';
    }

    protected function defaultQuery(): array
    {
        return array_filter([
            'nickname' => $this->searchQuery,
            'offset' => $this->offset,
            'limit' => $this->limit,
            'game' => $this->filters['game'] ?? null,
            'country' => $this->filters['country'] ?? null,
        ], static fn (mixed $value): bool => $value !== null);
    }

    /**
     * @return PaginatedResponse<Player>
     */
    public function createDtoFromResponse(Response $response): PaginatedResponse
    {
        return PaginatedResponse::fromArray($response->json(), Player::fromArray(...));
    }
}
