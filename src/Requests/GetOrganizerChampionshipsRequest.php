<?php

namespace Philicevic\FaceitPhp\Requests;

use Philicevic\FaceitPhp\DTO\Championship\Championship;
use Philicevic\FaceitPhp\DTO\PaginatedResponse;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

class GetOrganizerChampionshipsRequest extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        protected readonly string $organizerId,
        protected readonly ?bool $publishedOnly = null,
        protected readonly int $offset = 0,
        protected readonly int $limit = 20,
        protected readonly ?string $sort = null,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/organizers/'.$this->organizerId.'/championships';
    }

    protected function defaultQuery(): array
    {
        return array_filter([
            'publishedOnly' => $this->publishedOnly,
            'offset' => $this->offset,
            'limit' => $this->limit,
            'sort' => $this->sort,
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
