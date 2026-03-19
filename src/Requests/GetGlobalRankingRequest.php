<?php

namespace Philicevic\FaceitPhp\Requests;

use Philicevic\FaceitPhp\DTO\PaginatedResponse;
use Philicevic\FaceitPhp\DTO\Ranking\GlobalRanking;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

class GetGlobalRankingRequest extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        protected readonly string $gameId,
        protected readonly string $region,
        protected readonly ?string $country = null,
        protected readonly int $offset = 0,
        protected readonly int $limit = 20,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/rankings/games/'.$this->gameId.'/regions/'.$this->region;
    }

    protected function defaultQuery(): array
    {
        return array_filter([
            'country' => $this->country,
            'offset' => $this->offset,
            'limit' => $this->limit,
        ], static fn (mixed $value): bool => $value !== null);
    }

    /**
     * @return PaginatedResponse<GlobalRanking>
     */
    public function createDtoFromResponse(Response $response): PaginatedResponse
    {
        $data = $response->json();

        return new PaginatedResponse(
            items: array_map(fn (array $r): GlobalRanking => GlobalRanking::fromArray($r), $data['items'] ?? []),
            start: $data['start'] ?? 0,
            end: $data['end'] ?? 0,
        );
    }
}
