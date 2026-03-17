<?php

namespace Philicevic\FaceitPhp\Requests;

use Philicevic\FaceitPhp\DTO\Match\Info;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

class GetMatchDetailsRequest extends Request
{
    public function __construct(protected readonly string $uuid) {}

    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return '/matches/'.$this->uuid;
    }

    public function createDtoFromResponse(Response $response): Info
    {
        $data = $response->json();

        return new Info(
            uuid: $data['match_id'],
            competitionId: $data['competition_id'],
            competitionName: $data['competition_name'],
            competitionType: $data['competition_type'],
            bestOf: $data['best_of'],
            status: $data['status'],
        );
    }
}
