<?php

declare(strict_types=1);

namespace Phastron\Sort;

/**
 * TimSort implementation - hybrid stable sorting algorithm.
 * Time Complexity: O(n log n)
 * Stable: Yes
 * In-Place: No
 */
final class TimSort implements SortInterface
{
    private const MIN_MERGE = 32;

    public function sort(array $array, ?callable $comparator = null): array
    {
        if (count($array) <= 1) {
            return $array;
        }

        $comparator = $comparator ?? [$this, 'defaultCompare'];
        $length = count($array);
        
        // Use insertion sort for small arrays
        if ($length < self::MIN_MERGE) {
            return $this->insertionSort($array, $comparator);
        }

        // Calculate minimum run length
        $minRun = $this->getMinRunLength($length);
        
        // Sort individual runs
        $runs = [];
        $start = 0;
        
        while ($start < $length) {
            $end = min($start + $minRun, $length);
            $run = array_slice($array, $start, $end - $start);
            $runs[] = $this->insertionSort($run, $comparator);
            $start = $end;
        }

        // Merge runs
        while (count($runs) > 1) {
            $newRuns = [];
            for ($i = 0; $i < count($runs) - 1; $i += 2) {
                $newRuns[] = $this->merge($runs[$i], $runs[$i + 1], $comparator);
            }
            if (count($runs) % 2 === 1) {
                $newRuns[] = $runs[count($runs) - 1];
            }
            $runs = $newRuns;
        }

        return $runs[0] ?? [];
    }

    public function getName(): string
    {
        return 'TimSort';
    }

    public function isStable(): bool
    {
        return true;
    }

    public function isInPlace(): bool
    {
        return false;
    }

    public function getTimeComplexity(): string
    {
        return 'O(n log n)';
    }

    private function insertionSort(array $array, callable $comparator): array
    {
        $length = count($array);
        for ($i = 1; $i < $length; $i++) {
            $key = $array[$i];
            $j = $i - 1;
            
            while ($j >= 0 && $comparator($array[$j], $key) > 0) {
                $array[$j + 1] = $array[$j];
                $j--;
            }
            $array[$j + 1] = $key;
        }
        
        return $array;
    }

    private function merge(array $left, array $right, callable $comparator): array
    {
        $result = [];
        $i = $j = 0;
        
        while ($i < count($left) && $j < count($right)) {
            if ($comparator($left[$i], $right[$j]) <= 0) {
                $result[] = $left[$i++];
            } else {
                $result[] = $right[$j++];
            }
        }
        
        // Add remaining elements
        while ($i < count($left)) {
            $result[] = $left[$i++];
        }
        while ($j < count($right)) {
            $result[] = $right[$j++];
        }
        
        return $result;
    }

    private function getMinRunLength(int $length): int
    {
        $r = 0;
        while ($length >= self::MIN_MERGE) {
            $r |= $length & 1;
            $length >>= 1;
        }
        return $length + $r;
    }

    private function defaultCompare($a, $b): int
    {
        if ($a === $b) {
            return 0;
        }
        return $a < $b ? -1 : 1;
    }
}
