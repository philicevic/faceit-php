<?php

namespace Philicevic\FaceitPhp\DTO\Tournament;

use Philicevic\FaceitPhp\Validation\ValidatesFields;
use Philicevic\FaceitPhp\Validation\ValidationContext;

readonly class Teams
{
    use ValidatesFields;

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

    protected static function fieldSchema(): array
    {
        return [
            'checked_in' => '?array',
            'finished' => '?array',
            'joined' => '?array',
            'started' => '?array',
        ];
    }

    public static function fromArray(array $data): self
    {
        ValidationContext::pushPath('TournamentTeams');
        try {
            static::validateData($data);

            return new self(
                checkedIn: array_map(Team::fromArray(...), $data['checked_in'] ?? []),
                finished: array_map(Team::fromArray(...), $data['finished'] ?? []),
                joined: array_map(Team::fromArray(...), $data['joined'] ?? []),
                started: array_map(Team::fromArray(...), $data['started'] ?? []),
            );
        } finally {
            ValidationContext::popPath();
        }
    }
}
