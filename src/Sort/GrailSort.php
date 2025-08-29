<?php

declare(strict_types=1);

namespace Phastron\Sort;

/**
 * GrailSort implementation - in-place stable merge sort.
 * Time Complexity: O(n log n)
 * Stable: Yes
 * In-Place: Yes
 */
final class GrailSort implements SortInterface
{
    public function sort(array $array, ?callable $comparator = null): array
    {
        // TODO: Implement GrailSort
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
        return 'GrailSort';
    }

    public function isStable(): bool
    {
        return true;
    }

    public function isInPlace(): bool
    {
        return true;
    }

    public function getTimeComplexity(): string
    {
        return 'O(n log n)';
    }
}
