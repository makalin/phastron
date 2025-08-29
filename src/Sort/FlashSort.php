<?php

declare(strict_types=1);

namespace Phastron\Sort;

/**
 * FlashSort implementation - distribution sort for numeric keys.
 * Time Complexity: O(n) for uniform distribution
 * Stable: No
 * In-Place: Yes
 */
final class FlashSort implements SortInterface
{
    public function sort(array $array, ?callable $comparator = null): array
    {
        // TODO: Implement FlashSort
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
        return 'FlashSort';
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
        return 'O(n) for uniform distribution';
    }
}
