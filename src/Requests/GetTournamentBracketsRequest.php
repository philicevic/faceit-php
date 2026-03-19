<?php

namespace Philicevic\FaceitPhp\Requests;

use Philicevic\FaceitPhp\DTO\Tournament\Brackets;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

class GetTournamentBracketsRequest extends Request
{
    protected Method $method = Method::GET;

    public function __construct(protected readonly string $tournamentId) {}

    public function resolveEndpoint(): string
    {
        return '/tournaments/'.$this->tournamentId.'/brackets';
    }

    public function createDtoFromResponse(Response $response): Brackets
    {
        return Brackets::fromArray($response->json());
    }
}
