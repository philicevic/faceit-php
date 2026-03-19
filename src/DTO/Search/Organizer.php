<?php

namespace Philicevic\FaceitPhp\DTO\Search;

readonly class Organizer
{
    /**
     * @param  array<string>  $games
     * @param  array<string>  $regions
     */
    public function __construct(
        public string $organizerId,
        public string $name,
        public string $avatar,
        public bool $active,
        public array $games,
        public array $regions,
    ) {}
}
