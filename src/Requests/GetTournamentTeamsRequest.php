<?php

namespace Philicevic\FaceitPhp\Requests;

use Philicevic\FaceitPhp\DTO\Tournament\Teams;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

class GetTournamentTeamsRequest extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        protected readonly string $tournamentId,
        protected readonly int $offset = 0,
        protected readonly int $limit = 20,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/tournaments/'.$this->tournamentId.'/teams';
    }

    protected function defaultQuery(): array
    {
        return [
            'offset' => $this->offset,
            'limit' => $this->limit,
        ];
    }

    public function createDtoFromResponse(Response $response): Teams
    {
        return Teams::fromArray($response->json());
    }
}
