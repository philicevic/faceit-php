<?php

namespace Philicevic\FaceitPhp\Requests;

use Philicevic\FaceitPhp\DTO\Game\MatchmakingSummary;
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
     * @return PaginatedResponse<MatchmakingSummary>
     */
    public function createDtoFromResponse(Response $response): PaginatedResponse
    {
        return PaginatedResponse::fromArray($response->json(), MatchmakingSummary::fromArray(...));
    }
}
