<?php

namespace Philicevic\FaceitPhp\DTO;

/**
 * @template T
 *
 * @implements \ArrayAccess<int|string, mixed>
 */
class PaginatedResponse implements \ArrayAccess
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

    /**
     * @param  callable(array): T  $itemMapper
     * @return self<T>
     */
    public static function fromArray(array $data, callable $itemMapper): self
    {
        return new self(
            items: array_map($itemMapper, $data['items'] ?? []),
            start: $data['start'] ?? 0,
            end: $data['end'] ?? 0,
            from: $data['from'] ?? null,
            to: $data['to'] ?? null,
        );
    }

    public function offsetExists(mixed $offset): bool
    {
        if (is_int($offset)) {
            return isset($this->items[$offset]);
        }

        return in_array($offset, ['items', 'start', 'end', 'from', 'to'], true);
    }

    public function offsetGet(mixed $offset): mixed
    {
        if (is_int($offset)) {
            return $this->items[$offset];
        }

        return match ($offset) {
            'items' => $this->items,
            'start' => $this->start,
            'end' => $this->end,
            'from' => $this->from,
            'to' => $this->to,
            default => null,
        };
    }

    public function offsetSet(mixed $offset, mixed $value): void
    {
        // immutable
    }

    public function offsetUnset(mixed $offset): void
    {
        // immutable
    }
}
