<?php

namespace Philicevic\FaceitPhp\Requests;

use Philicevic\FaceitPhp\DTO\Game\Game;
use Philicevic\FaceitPhp\DTO\PaginatedResponse;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

class GetGamesRequest extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        protected readonly int $offset = 0,
        protected readonly int $limit = 20,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/games';
    }

    protected function defaultQuery(): array
    {
        return [
            'offset' => $this->offset,
            'limit' => $this->limit,
        ];
    }

    /**
     * @return PaginatedResponse<Game>
     */
    public function createDtoFromResponse(Response $response): PaginatedResponse
    {
        $data = $response->json();

        $items = array_map(fn (array $g): Game => Game::fromArray($g), $data['items'] ?? []);

        return new PaginatedResponse(
            items: $items,
            start: $data['start'] ?? 0,
            end: $data['end'] ?? 0,
        );
    }
}
