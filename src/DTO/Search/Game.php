<?php

namespace Philicevic\FaceitPhp\DTO\Search;

readonly class Game
{
    public function __construct(
        public string $name,
        public string $skillLevel,
    ) {}
}
