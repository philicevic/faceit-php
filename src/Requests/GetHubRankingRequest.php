<?php

namespace Philicevic\FaceitPhp\Requests;

use Philicevic\FaceitPhp\DTO\Leaderboard\EntityRanking;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

class GetHubRankingRequest extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        protected readonly string $hubId,
        protected readonly int $offset = 0,
        protected readonly int $limit = 20,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/leaderboards/hubs/'.$this->hubId.'/general';
    }

    protected function defaultQuery(): array
    {
        return [
            'offset' => $this->offset,
            'limit' => $this->limit,
        ];
    }

    public function createDtoFromResponse(Response $response): EntityRanking
    {
        return EntityRanking::fromArray($response->json());
    }
}
