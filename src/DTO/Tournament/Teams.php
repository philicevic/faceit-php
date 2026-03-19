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
        $hydrate = fn (array $teams): array => array_map(fn (array $t): Team => Team::fromArray($t), $teams);

        return new self(
            checkedIn: $hydrate($data['checked_in'] ?? []),
            finished: $hydrate($data['finished'] ?? []),
            joined: $hydrate($data['joined'] ?? []),
            started: $hydrate($data['started'] ?? []),
        );
    }
}
