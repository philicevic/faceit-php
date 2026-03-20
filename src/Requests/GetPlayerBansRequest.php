<?php

namespace Philicevic\FaceitPhp\Requests;

use Philicevic\FaceitPhp\DTO\Ban;
use Philicevic\FaceitPhp\DTO\PaginatedResponse;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

class GetPlayerBansRequest extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        protected readonly string $playerId,
        protected readonly int $offset = 0,
        protected readonly int $limit = 20,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/players/'.$this->playerId.'/bans';
    }

    protected function defaultQuery(): array
    {
        return [
            'offset' => $this->offset,
            'limit' => $this->limit,
        ];
    }

    /**
     * @return PaginatedResponse<Ban>
     */
    public function createDtoFromResponse(Response $response): PaginatedResponse
    {
        return PaginatedResponse::fromArray($response->json(), Ban::fromArray(...));
    }
}
