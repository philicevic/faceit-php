<?php

use Philicevic\FaceitPhp\Faceit;
use Saloon\Http\Faking\MockClient;

function faceitMock(): Faceit
{
    MockClient::destroyGlobal();
    return new Faceit('fake-api-key');
}