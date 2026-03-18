<?php

namespace Philicevic\FaceitPhp\DTO;

/**
 * @template T
 */
class PaginatedResponse
{
    /**
     * @param  array<T>  $items
     */
    public function __construct(
        public array $items,
        public int $start,
        public int $end,
        public ?int $from = null,
        public ?int $to = null,
    ) {}
}
