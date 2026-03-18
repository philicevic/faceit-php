<?php

namespace Philicevic\FaceitPhp\DTO\Search;

class Game
{
    public function __construct(
        public readonly string $name,
        public readonly string $skillLevel,
    ) {}
}
