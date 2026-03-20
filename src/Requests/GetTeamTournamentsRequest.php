<?php

namespace Philicevic\FaceitPhp\Requests;

use Philicevic\FaceitPhp\DTO\PaginatedResponse;
use Philicevic\FaceitPhp\DTO\Player\Tournament;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

class GetTeamTournamentsRequest extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        protected readonly string $teamId,
        protected readonly int $offset = 0,
        protected readonly int $limit = 20,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/teams/'.$this->teamId.'/tournaments';
    }

    protected function defaultQuery(): array
    {
        return [
            'offset' => $this->offset,
            'limit' => $this->limit,
        ];
    }

    /**
     * @return PaginatedResponse<Tournament>
     */
    public function createDtoFromResponse(Response $response): PaginatedResponse
    {
        return PaginatedResponse::fromArray($response->json(), Tournament::fromArray(...));
    }
}
