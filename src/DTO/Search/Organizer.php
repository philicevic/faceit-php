<?php

namespace Philicevic\FaceitPhp\DTO\Search;

class Organizer
{
    /**
     * @param  array<string>  $games
     * @param  array<string>  $regions
     */
    public function __construct(
        public readonly string $organizerId,
        public readonly string $name,
        public readonly string $avatar,
        public readonly bool $active,
        public readonly array $games,
        public readonly array $regions,
    ) {}
}
