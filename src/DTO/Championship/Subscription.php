<?php

namespace Philicevic\FaceitPhp\DTO\Championship;

use Philicevic\FaceitPhp\DTO\Team\Team;
use Philicevic\FaceitPhp\Validation\ValidatesFields;
use Philicevic\FaceitPhp\Validation\ValidationContext;

readonly class Subscription
{
    use ValidatesFields;

    /**
     * @param  array<string>  $roster
     * @param  array<string>  $substitutes
     */
    public function __construct(
        public string $coach,
        public string $coleader,
        public int $group,
        public string $leader,
        public array $roster,
        public string $status,
        public array $substitutes,
        public ?Team $team,
    ) {}

    protected static function fieldSchema(): array
    {
        return [
            'coach' => '?string',
            'coleader' => '?string',
            'group' => '?int',
            'leader' => '?string',
            'roster' => '?array',
            'status' => '?string',
            'substitutes' => '?array',
            'team' => '?array',
        ];
    }

    public static function fromArray(array $data): self
    {
        ValidationContext::pushPath('Subscription');
        try {
            static::validateData($data);

            return new self(
                coach: (string) ($data['coach'] ?? ''),
                coleader: (string) ($data['coleader'] ?? ''),
                group: (int) ($data['group'] ?? 0),
                leader: (string) ($data['leader'] ?? ''),
                roster: $data['roster'] ?? [],
                status: (string) ($data['status'] ?? ''),
                substitutes: $data['substitutes'] ?? [],
                team: isset($data['team']) ? Team::fromArray($data['team']) : null,
            );
        } finally {
            ValidationContext::popPath();
        }
    }
}
