<?php

use Philicevic\FaceitPhp\Faceit;
use Saloon\Http\Faking\MockClient;

function faceitMock(bool $strict = false): Faceit
{
    MockClient::destroyGlobal();

    return new Faceit('fake-api-key', strict: $strict);
}
