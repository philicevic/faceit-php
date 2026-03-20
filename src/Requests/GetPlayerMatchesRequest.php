<?php

namespace Philicevic\FaceitPhp\Requests;

use Philicevic\FaceitPhp\DTO\Match\Summary\Info;
use Philicevic\FaceitPhp\DTO\PaginatedResponse;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

class GetPlayerMatchesRequest extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        protected readonly string $playerId,
        protected readonly string $game,
        protected readonly ?int $from = null,
        protected readonly ?int $to = null,
        protected readonly int $offset = 0,
        protected readonly int $limit = 20,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/players/'.$this->playerId.'/history';
    }

    protected function defaultQuery(): array
    {
        return array_filter([
            'game' => $this->game,
            'from' => $this->from,
            'to' => $this->to,
            'offset' => $this->offset,
            'limit' => $this->limit,
        ], static fn (mixed $value): bool => $value !== null);
    }

    /**
     * @return PaginatedResponse<Info>
     */
    public function createDtoFromResponse(Response $response): PaginatedResponse
    {
        return PaginatedResponse::fromArray($response->json(), Info::fromArray(...));
    }
}
