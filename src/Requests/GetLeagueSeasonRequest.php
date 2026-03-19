<?php

namespace Philicevic\FaceitPhp\Requests;

use Philicevic\FaceitPhp\DTO\League\Division;
use Philicevic\FaceitPhp\DTO\League\Season;
use Philicevic\FaceitPhp\DTO\League\SeasonDetailed;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

class GetLeagueSeasonRequest extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        protected readonly string $leagueId,
        protected readonly string $seasonId,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/leagues/'.$this->leagueId.'/seasons/'.$this->seasonId;
    }

    public function createDtoFromResponse(Response $response): SeasonDetailed
    {
        $data = $response->json();
        $s = $data['season'] ?? [];

        return new SeasonDetailed(
            season: new Season(
                number: (int) ($s['number'] ?? 0),
                startDate: (string) ($s['start_date'] ?? ''),
                endDate: (string) ($s['end_date'] ?? ''),
                placementMatchCount: (int) ($s['placement_match_count'] ?? 0),
            ),
            divisions: array_map(fn (array $d): Division => Division::fromArray($d), $data['divisions'] ?? []),
        );
    }
}
