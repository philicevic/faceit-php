<?php

namespace Philicevic\FaceitPhp\Requests;

use Philicevic\FaceitPhp\DTO\Hub\Member;
use Philicevic\FaceitPhp\DTO\PaginatedResponse;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

class GetHubMembersRequest extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        protected readonly string $hubId,
        protected readonly int $offset = 0,
        protected readonly int $limit = 20,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/hubs/'.$this->hubId.'/members';
    }

    protected function defaultQuery(): array
    {
        return [
            'offset' => $this->offset,
            'limit' => $this->limit,
        ];
    }

    /**
     * @return PaginatedResponse<Member>
     */
    public function createDtoFromResponse(Response $response): PaginatedResponse
    {
        $data = $response->json();

        return new PaginatedResponse(
            items: array_map(fn (array $m): Member => Member::fromArray($m), $data['items'] ?? []),
            start: $data['start'] ?? 0,
            end: $data['end'] ?? 0,
        );
    }
}
