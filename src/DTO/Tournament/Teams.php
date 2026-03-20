<?php

namespace Philicevic\FaceitPhp\DTO\Tournament;

readonly class Teams
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

    public static function fromArray(array $data): self
    {
        return new self(
            checkedIn: array_map(Team::fromArray(...), $data['checked_in'] ?? []),
            finished: array_map(Team::fromArray(...), $data['finished'] ?? []),
            joined: array_map(Team::fromArray(...), $data['joined'] ?? []),
            started: array_map(Team::fromArray(...), $data['started'] ?? []),
        );
    }
}
