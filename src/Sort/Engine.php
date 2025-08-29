<?php

declare(strict_types=1);

namespace Phastron\Sort;

/**
 * Main sorting engine that provides access to all sorting algorithms.
 */
final class Engine
{
    // Algorithm constants
    public const TIM_SORT = 'tim_sort';
    public const PATTERN_DEFEATING_QUICKSORT = 'pdq_sort';
    public const DUAL_PIVOT_QUICKSORT = 'dual_pivot_quicksort';
    public const GRAIL_SORT = 'grail_sort';
    public const PDQ_SORT_BRANCHLESS = 'pdq_sort_branchless';
    public const BITONIC_SORT = 'bitonic_sort';
    public const FLASH_SORT = 'flash_sort';
    public const CYCLE_SORT = 'cycle_sort';

    private static array $algorithms = [
        self::TIM_SORT => TimSort::class,
        self::PATTERN_DEFEATING_QUICKSORT => PatternDefeatingQuickSort::class,
        self::DUAL_PIVOT_QUICKSORT => DualPivotQuickSort::class,
        self::GRAIL_SORT => GrailSort::class,
        self::PDQ_SORT_BRANCHLESS => PDQSortBranchless::class,
        self::BITONIC_SORT => BitonicSort::class,
        self::FLASH_SORT => FlashSort::class,
        self::CYCLE_SORT => CycleSort::class,
    ];

    /**
     * Sort an array using the specified algorithm.
     *
     * @param array $array The array to sort
     * @param string $algorithm The algorithm to use
     * @param callable|null $comparator Optional custom comparator function
     * @return array The sorted array
     * @throws \InvalidArgumentException If the algorithm is not supported
     */
    public static function sort(array $array, string $algorithm = self::TIM_SORT, ?callable $comparator = null): array
    {
        if (!isset(self::$algorithms[$algorithm])) {
            throw new \InvalidArgumentException("Unsupported sorting algorithm: {$algorithm}");
        }

        $algorithmClass = self::$algorithms[$algorithm];
        $sorter = new $algorithmClass();
        
        return $sorter->sort($array, $comparator);
    }

    /**
     * Get all available sorting algorithms.
     *
     * @return array List of algorithm names
     */
    public static function getAvailableAlgorithms(): array
    {
        return array_keys(self::$algorithms);
    }

    /**
     * Check if an algorithm is supported.
     *
     * @param string $algorithm The algorithm name
     * @return bool True if supported
     */
    public static function isAlgorithmSupported(string $algorithm): bool
    {
        return isset(self::$algorithms[$algorithm]);
    }
}
