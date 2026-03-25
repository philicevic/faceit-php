<?php

namespace Philicevic\FaceitPhp\Requests;

use Philicevic\FaceitPhp\DTO\Championship\Subscription;
use Philicevic\FaceitPhp\DTO\PaginatedResponse;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

class GetChampionshipSubscriptionsRequest extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        protected readonly string $championshipId,
        protected readonly int $offset = 0,
        protected readonly int $limit = 10,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/championships/'.$this->championshipId.'/subscriptions';
    }

    protected function defaultQuery(): array
    {
        return [
            'offset' => $this->offset,
            'limit' => $this->limit,
        ];
    }

    /**
     * @return PaginatedResponse<Subscription>
     */
    public function createDtoFromResponse(Response $response): PaginatedResponse
    {
        return PaginatedResponse::fromArray($response->json(), Subscription::fromArray(...));
    }
}
