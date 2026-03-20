<?php

namespace Philicevic\FaceitPhp\Requests;

use Philicevic\FaceitPhp\DTO\Leaderboard\Leaderboard;
use Philicevic\FaceitPhp\DTO\PaginatedResponse;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

class GetChampionshipLeaderboardsRequest extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        protected readonly string $championshipId,
        protected readonly int $offset = 0,
        protected readonly int $limit = 20,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/leaderboards/championships/'.$this->championshipId;
    }

    protected function defaultQuery(): array
    {
        return [
            'offset' => $this->offset,
            'limit' => $this->limit,
        ];
    }

    /**
     * @return PaginatedResponse<Leaderboard>
     */
    public function createDtoFromResponse(Response $response): PaginatedResponse
    {
        return PaginatedResponse::fromArray($response->json(), Leaderboard::fromArray(...));
    }
}
