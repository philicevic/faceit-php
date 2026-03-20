<?php

namespace Philicevic\FaceitPhp\Requests;

use Philicevic\FaceitPhp\DTO\Championship\Championship;
use Philicevic\FaceitPhp\DTO\PaginatedResponse;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

class GetChampionshipsRequest extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        protected readonly string $game,
        protected readonly ?string $type = null,
        protected readonly int $offset = 0,
        protected readonly int $limit = 10,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/championships';
    }

    protected function defaultQuery(): array
    {
        return array_filter([
            'game' => $this->game,
            'type' => $this->type,
            'offset' => $this->offset,
            'limit' => $this->limit,
        ], static fn (mixed $value): bool => $value !== null);
    }

    /**
     * @return PaginatedResponse<Championship>
     */
    public function createDtoFromResponse(Response $response): PaginatedResponse
    {
        return PaginatedResponse::fromArray($response->json(), Championship::fromArray(...));
    }
}
