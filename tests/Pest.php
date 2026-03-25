<?php

use Philicevic\FaceitPhp\Faceit;
use Saloon\Http\Faking\MockClient;

function faceitMock(bool $strict = false): Faceit
{
    MockClient::destroyGlobal();

    return new Faceit('9b6c9145-e285-40f2-959e-16f55f9e9691', strict: $strict);
}
