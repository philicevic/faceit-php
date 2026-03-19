<?php

namespace Philicevic\FaceitPhp\Requests;

use Philicevic\FaceitPhp\DTO\Game\Matchmaking;
use Philicevic\FaceitPhp\DTO\PaginatedResponse;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

class GetGameMatchmakingsRequest extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        protected readonly string $gameId,
        protected readonly ?string $region = null,
        protected readonly int $offset = 0,
        protected readonly int $limit = 20,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/games/'.$this->gameId.'/matchmakings';
    }

    protected function defaultQuery(): array
    {
        return array_filter([
            'region' => $this->region,
            'offset' => $this->offset,
            'limit' => $this->limit,
        ], static fn (mixed $value): bool => $value !== null);
    }

    /**
     * @return PaginatedResponse<Matchmaking>
     */
    public function createDtoFromResponse(Response $response): PaginatedResponse
    {
        $data = $response->json();

        return new PaginatedResponse(
            items: array_map(fn (array $m): Matchmaking => Matchmaking::fromArray($m), $data['items'] ?? []),
            start: $data['start'] ?? 0,
            end: $data['end'] ?? 0,
        );
    }
}
