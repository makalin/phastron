<?php

declare(strict_types=1);

namespace Phastron\Sort;

/**
 * BitonicSort implementation - GPU-friendly parallel sort.
 * Time Complexity: O(log² n)
 * Stable: No
 * In-Place: Yes
 */
final class BitonicSort implements SortInterface
{
    public function sort(array $array, ?callable $comparator = null): array
    {
        // TODO: Implement BitonicSort
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
        return 'BitonicSort';
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
        return 'O(log² n)';
    }
}
