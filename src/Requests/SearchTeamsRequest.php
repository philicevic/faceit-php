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
        $data = $response->json();
        $items = array_map(fn (array $item): Team => new Team(
            teamId: $item['team_id'],
            name: $item['name'],
            game: (string) ($item['game'] ?? ''),
            avatar: (string) ($item['avatar'] ?? ''),
            faceitUrl: (string) ($item['faceit_url'] ?? ''),
            verified: (bool) ($item['verified'] ?? false),
        ), $data['items'] ?? []);

        return new PaginatedResponse(
            items: $items,
            start: $data['start'] ?? 0,
            end: $data['end'] ?? 0,
        );
    }
}
