<?php

namespace Philicevic\FaceitPhp\Requests;

use Philicevic\FaceitPhp\DTO\Match\Stats\MatchStats;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

class GetMatchStatsRequest extends Request
{
    public function __construct(protected readonly string $uuid) {}

    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return '/matches/'.$this->uuid.'/stats';
    }

    public function createDtoFromResponse(Response $response): MatchStats
    {
        return MatchStats::fromArray($response->json());
    }
}
