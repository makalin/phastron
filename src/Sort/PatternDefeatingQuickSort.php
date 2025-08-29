<?php

declare(strict_types=1);

namespace Phastron\Sort;

/**
 * Pattern-Defeating QuickSort implementation.
 * Time Complexity: O(n log n) average
 * Stable: No
 * In-Place: Yes
 */
final class PatternDefeatingQuickSort implements SortInterface
{
    public function sort(array $array, ?callable $comparator = null): array
    {
        // TODO: Implement Pattern-Defeating QuickSort
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
        return 'Pattern-Defeating QuickSort';
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
        return 'O(n log n) average';
    }
}
