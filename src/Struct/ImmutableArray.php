<?php

declare(strict_types=1);

namespace Phastron\Struct;

/**
 * Immutable array implementation with functional programming methods.
 */
final class ImmutableArray
{
    private array $data;

    private function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Create from an array.
     *
     * @param array $data Input array
     * @return self
     */
    public static function from(array $data): self
    {
        return new self($data);
    }

    /**
     * Create from a range of numbers.
     *
     * @param int $start Start value
     * @param int $end End value
     * @param int $step Step value
     * @return self
     */
    public static function range(int $start, int $end, int $step = 1): self
    {
        return new self(range($start, $end, $step));
    }

    /**
     * Create from repeated values.
     *
     * @param mixed $value Value to repeat
     * @param int $count Number of repetitions
     * @return self
     */
    public static function repeat($value, int $count): self
    {
        return new self(array_fill(0, $count, $value));
    }

    /**
     * Map over the array.
     *
     * @param callable $callback Mapping function
     * @return self New instance with mapped values
     */
    public function map(callable $callback): self
    {
        return new self(array_map($callback, $this->data));
    }

    /**
     * Filter the array.
     *
     * @param callable $callback Filtering function
     * @return self New instance with filtered values
     */
    public function filter(callable $callback): self
    {
        return new self(array_filter($this->data, $callback));
    }

    /**
     * Reduce the array to a single value.
     *
     * @param callable $callback Reducing function
     * @param mixed $initial Initial value
     * @return mixed Reduced value
     */
    public function reduce(callable $callback, $initial = null)
    {
        return array_reduce($this->data, $callback, $initial);
    }

    /**
     * Flat map over the array.
     *
     * @param callable $callback Flat mapping function
     * @return self New instance with flat mapped values
     */
    public function flatMap(callable $callback): self
    {
        $result = [];
        foreach ($this->data as $item) {
            $mapped = $callback($item);
            if (is_array($mapped)) {
                $result = array_merge($result, $mapped);
            } else {
                $result[] = $mapped;
            }
        }
        return new self($result);
    }

    /**
     * Take first n elements.
     *
     * @param int $count Number of elements to take
     * @return self New instance with first n elements
     */
    public function take(int $count): self
    {
        return new self(array_slice($this->data, 0, $count));
    }

    /**
     * Take last n elements.
     *
     * @param int $count Number of elements to take
     * @return self New instance with last n elements
     */
    public function takeLast(int $count): self
    {
        return new self(array_slice($this->data, -$count));
    }

    /**
     * Skip first n elements.
     *
     * @param int $count Number of elements to skip
     * @return self New instance with remaining elements
     */
    public function skip(int $count): self
    {
        return new self(array_slice($this->data, $count));
    }

    /**
     * Skip last n elements.
     *
     * @param int $count Number of elements to skip
     * @return self New instance with remaining elements
     */
    public function skipLast(int $count): self
    {
        return new self(array_slice($this->data, 0, -$count));
    }

    /**
     * Reverse the array.
     *
     * @return self New instance with reversed order
     */
    public function reverse(): self
    {
        return new self(array_reverse($this->data));
    }

    /**
     * Sort the array.
     *
     * @param callable|null $comparator Optional comparison function
     * @return self New instance with sorted values
     */
    public function sort(?callable $comparator = null): self
    {
        $sorted = $this->data;
        if ($comparator) {
            usort($sorted, $comparator);
        } else {
            sort($sorted);
        }
        return new self($sorted);
    }

    /**
     * Get unique values.
     *
     * @return self New instance with unique values
     */
    public function unique(): self
    {
        return new self(array_unique($this->data));
    }

    /**
     * Check if all elements satisfy a condition.
     *
     * @param callable $callback Test function
     * @return bool True if all elements pass the test
     */
    public function all(callable $callback): bool
    {
        foreach ($this->data as $item) {
            if (!$callback($item)) {
                return false;
            }
        }
        return true;
    }

    /**
     * Check if any element satisfies a condition.
     *
     * @param callable $callback Test function
     * @return bool True if any element passes the test
     */
    public function any(callable $callback): bool
    {
        foreach ($this->data as $item) {
            if ($callback($item)) {
                return true;
            }
        }
        return false;
    }

    /**
     * Find first element that satisfies a condition.
     *
     * @param callable $callback Test function
     * @return mixed First matching element or null
     */
    public function find(callable $callback)
    {
        foreach ($this->data as $item) {
            if ($callback($item)) {
                return $item;
            }
        }
        return null;
    }

    /**
     * Get the first element.
     *
     * @return mixed First element or null
     */
    public function first()
    {
        return $this->data[0] ?? null;
    }

    /**
     * Get the last element.
     *
     * @return mixed Last element or null
     */
    public function last()
    {
        return end($this->data) ?: null;
    }

    /**
     * Get the count of elements.
     *
     * @return int Number of elements
     */
    public function count(): int
    {
        return count($this->data);
    }

    /**
     * Check if the array is empty.
     *
     * @return bool True if empty
     */
    public function isEmpty(): bool
    {
        return empty($this->data);
    }

    /**
     * Convert to regular array.
     *
     * @return array Regular PHP array
     */
    public function toArray(): array
    {
        return $this->data;
    }

    /**
     * Convert to JSON string.
     *
     * @return string JSON representation
     */
    public function toJson(): string
    {
        return json_encode($this->data);
    }

    /**
     * Get array keys.
     *
     * @return self New instance with keys
     */
    public function keys(): self
    {
        return new self(array_keys($this->data));
    }

    /**
     * Get array values.
     *
     * @return self New instance with values
     */
    public function values(): self
    {
        return new self(array_values($this->data));
    }

    /**
     * Chunk the array into smaller arrays.
     *
     * @param int $size Size of each chunk
     * @return self New instance with chunked arrays
     */
    public function chunk(int $size): self
    {
        return new self(array_chunk($this->data, $size));
    }
}
