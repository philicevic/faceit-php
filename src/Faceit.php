<?php

namespace Philicevic\FaceitPhp;

use Philicevic\FaceitPhp\Resources\MatchResource;
use Philicevic\FaceitPhp\Resources\PlayerResource;
use Saloon\Contracts\Authenticator;
use Saloon\Http\Auth\TokenAuthenticator;
use Saloon\Http\Connector;

class Faceit extends Connector
{
    public function __construct(public readonly string $token)
    {
    }

    public function resolveBaseUrl(): string
    {
        return 'https://open.faceit.com/data/v4';
    }

    protected function defaultHeaders(): array
    {
        return [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ];
    }

    protected function defaultAuth(): TokenAuthenticator
    {
        return new TokenAuthenticator($this->token);
    }

    public function match(): MatchResource
    {
        return new MatchResource($this);
    }

    public function player(): PlayerResource
    {
        return new PlayerResource($this);
    }
}