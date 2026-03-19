<?php

namespace Philicevic\FaceitPhp\Requests;

use Philicevic\FaceitPhp\DTO\League\Division;
use Philicevic\FaceitPhp\DTO\League\League;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

class GetLeagueRequest extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        protected readonly string $leagueId,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/leagues/'.$this->leagueId;
    }

    public function createDtoFromResponse(Response $response): League
    {
        $data = $response->json();

        return new League(
            uuid: $data['id'],
            game: (string) ($data['game'] ?? ''),
            region: (string) ($data['region'] ?? ''),
            minMatches: (int) ($data['min_matches'] ?? 0),
            divisions: array_map(fn (array $d): Division => Division::fromArray($d), $data['divisions'] ?? []),
        );
    }
}
