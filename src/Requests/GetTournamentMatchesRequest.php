<?php

namespace Philicevic\FaceitPhp\Requests;

use Philicevic\FaceitPhp\DTO\Match\Detail\Info;
use Philicevic\FaceitPhp\DTO\PaginatedResponse;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

class GetTournamentMatchesRequest extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        protected readonly string $tournamentId,
        protected readonly int $offset = 0,
        protected readonly int $limit = 20,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/tournaments/'.$this->tournamentId.'/matches';
    }

    protected function defaultQuery(): array
    {
        return [
            'offset' => $this->offset,
            'limit' => $this->limit,
        ];
    }

    /**
     * @return PaginatedResponse<Info>
     */
    public function createDtoFromResponse(Response $response): PaginatedResponse
    {
        return PaginatedResponse::fromArray($response->json(), Info::fromArray(...));
    }
}
