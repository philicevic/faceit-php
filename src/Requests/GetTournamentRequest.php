<?php

namespace Philicevic\FaceitPhp\Requests;

use Philicevic\FaceitPhp\DTO\Tournament\Tournament;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

class GetTournamentRequest extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        protected readonly string $tournamentId,
        protected readonly ?string $expanded = null,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/tournaments/'.$this->tournamentId;
    }

    protected function defaultQuery(): array
    {
        return array_filter([
            'expanded' => $this->expanded,
        ], static fn (mixed $value): bool => $value !== null);
    }

    public function createDtoFromResponse(Response $response): Tournament
    {
        return Tournament::fromArray($response->json());
    }
}
