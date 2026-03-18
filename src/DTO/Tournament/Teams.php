<?php

namespace Philicevic\FaceitPhp\DTO\Tournament;

class Teams
{
    /**
     * @param  array<Team>  $checkedIn
     * @param  array<Team>  $finished
     * @param  array<Team>  $joined
     * @param  array<Team>  $started
     */
    public function __construct(
        public array $checkedIn,
        public array $finished,
        public array $joined,
        public array $started,
    ) {}
}
