<?php

namespace Philicevic\FaceitPhp\Requests;

use Philicevic\FaceitPhp\DTO\PaginatedResponse;
use Philicevic\FaceitPhp\DTO\Player\Tournament;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

class GetPlayerTournamentsRequest extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        protected readonly string $playerId,
        protected readonly int $offset = 0,
        protected readonly int $limit = 20,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/players/'.$this->playerId.'/tournaments';
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
        $data = $response->json();

        return new PaginatedResponse(
            items: array_map(fn (array $t): Tournament => Tournament::fromArray($t), $data['items'] ?? []),
            start: $data['start'] ?? 0,
            end: $data['end'] ?? 0,
        );
    }
}
