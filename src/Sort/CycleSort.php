<?php

declare(strict_types=1);

namespace Phastron\Sort;

/**
 * CycleSort implementation - minimizes writes, perfect for EEPROM.
 * Time Complexity: O(n²)
 * Stable: No
 * In-Place: Yes
 */
final class CycleSort implements SortInterface
{
    public function sort(array $array, ?callable $comparator = null): array
    {
        // TODO: Implement CycleSort
        // This is a placeholder implementation
        $sorted = $array;
        if ($comparator) {
            usort($sorted, $comparator);
        } else {
            sort($sorted);
        }
        return $sorted;
    }

    public function getName(): string
    {
        return 'CycleSort';
    }

    public function isStable(): bool
    {
        return false;
    }

    public function isInPlace(): bool
    {
        return true;
    }

    public function getTimeComplexity(): string
    {
        return 'O(n²)';
    }
}
