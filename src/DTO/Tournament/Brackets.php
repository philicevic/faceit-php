<?php

namespace Philicevic\FaceitPhp\DTO\Tournament;

class Brackets
{
    /**
     * @param  array<BracketsMatch>  $matches
     * @param  array<BracketsRound>  $rounds
     */
    public function __construct(
        public string $game,
        public string $name,
        public string $status,
        public array $matches,
        public array $rounds,
    ) {}
}
