<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use Phastron\Sort\Engine;
use Phastron\Tools\Stopwatch;
use Phastron\Cli\Color;

echo Color::gradient("🏁 Phastron Sorting Algorithm Benchmarks", '#ff6b6b', '#4ecdc4') . "\n\n";

// Test data generation functions
function generateRandomArray(int $size): array
{
    $array = range(1, $size);
    shuffle($array);
    return $array;
}

function generateNearlySortedArray(int $size): array
{
    $array = range(1, $size);
    // Swap 10% of elements randomly
    $swaps = (int) ($size * 0.1);
    for ($i = 0; $i < $swaps; $i++) {
        $idx1 = random_int(0, $size - 1);
        $idx2 = random_int(0, $size - 1);
        [$array[$idx1], $array[$idx2]] = [$array[$idx2], $array[$idx1]];
    }
    return $array;
}

function generateReverseSortedArray(int $size): array
{
    return range($size, 1);
}

function generateDuplicateArray(int $size): array
{
    $array = [];
    for ($i = 0; $i < $size; $i++) {
        $array[] = random_int(1, $size / 10); // Many duplicates
    }
    return $array;
}

// Benchmark function
function benchmarkAlgorithm(string $algorithm, array $data, int $iterations = 3): array
{
    $times = [];
    
    for ($i = 0; $i < $iterations; $i++) {
        $testData = $data;
        $stopwatch = Stopwatch::startNew();
        Engine::sort($testData, $algorithm);
        $stopwatch->stop();
        $times[] = $stopwatch->getElapsedMilliseconds();
    }
    
    $avgTime = array_sum($times) / count($times);
    $minTime = min($times);
    $maxTime = max($times);
    
    return [
        'algorithm' => $algorithm,
        'average' => $avgTime,
        'min' => $minTime,
        'max' => $maxTime,
        'iterations' => $iterations
    ];
}

// Test scenarios
$scenarios = [
    'Random Data' => 'generateRandomArray',
    'Nearly Sorted' => 'generateNearlySortedArray',
    'Reverse Sorted' => 'generateReverseSortedArray',
    'Many Duplicates' => 'generateDuplicateArray'
];

$sizes = [100, 1000, 10000, 50000];
$algorithms = [
    Engine::TIM_SORT,
    Engine::PATTERN_DEFEATING_QUICKSORT,
    Engine::DUAL_PIVOT_QUICKSORT,
    Engine::GRAIL_SORT,
    Engine::PDQ_SORT_BRANCHLESS,
    Engine::BITONIC_SORT,
    Engine::FLASH_SORT,
    Engine::CYCLE_SORT
];

// Run comprehensive benchmarks
foreach ($scenarios as $scenarioName => $generatorFunc) {
    echo Color::bold("📊 {$scenarioName}") . "\n";
    echo str_repeat("=", 50) . "\n";
    
    foreach ($sizes as $size) {
        echo "\nArray Size: " . number_format($size) . "\n";
        echo str_repeat("-", 30) . "\n";
        
        $data = $generatorFunc($size);
        $results = [];
        
        foreach ($algorithms as $algorithm) {
            $result = benchmarkAlgorithm($algorithm, $data);
            $results[] = $result;
            
            echo sprintf("%-25s: %8.3f ms (min: %6.3f, max: %6.3f)\n",
                $algorithm,
                $result['average'],
                $result['min'],
                $result['max']
            );
        }
        
        // Find fastest algorithm for this scenario and size
        $fastest = $results[0];
        foreach ($results as $result) {
            if ($result['average'] < $fastest['average']) {
                $fastest = $result;
            }
        }
        echo "\n🏆 Fastest: " . Color::colorize($fastest['algorithm'], 'green') . 
             " ({$fastest['average']:.3f} ms)\n";
    }
    
    echo "\n" . str_repeat("=", 50) . "\n\n";
}

// Memory usage analysis
echo Color::bold("💾 Memory Usage Analysis") . "\n";
echo str_repeat("=", 50) . "\n";

$testSize = 10000;
$testData = generateRandomArray($testSize);

foreach ($algorithms as $algorithm) {
    $memoryBefore = memory_get_usage();
    $testDataCopy = $testData;
    
    $stopwatch = Stopwatch::startNew();
    $sorted = Engine::sort($testDataCopy, $algorithm);
    $stopwatch->stop();
    
    $memoryAfter = memory_get_usage();
    $memoryUsed = $memoryAfter - $memoryBefore;
    
    echo sprintf("%-25s: %8.3f ms, %8s bytes\n",
        $algorithm,
        $stopwatch->getElapsedMilliseconds(),
        number_format($memoryUsed)
    );
}

// Stability test
echo "\n" . Color::bold("🔒 Stability Test") . "\n";
echo str_repeat("=", 50) . "\n";

$stabilityData = [
    array('name' => 'Alice', 'age' => 25),
    array('name' => 'Bob', 'age' => 25),
    array('name' => 'Charlie', 'age' => 30),
    array('name' => 'David', 'age' => 25),
    array('name' => 'Eve', 'age' => 30)
];

$comparator = function($a, $b) {
    return $a['age'] <=> $b['age'];
};

foreach ($algorithms as $algorithm) {
    $sorted = Engine::sort($stabilityData, $algorithm, $comparator);
    
    // Check if original order is preserved for same age
    $stable = true;
    $lastAge = null;
    $lastIndex = -1;
    
    foreach ($sorted as $index => $item) {
        if ($item['age'] === $lastAge && $index < $lastIndex) {
            $stable = false;
            break;
        }
        $lastAge = $item['age'];
        $lastIndex = $index;
    }
    
    $status = $stable ? Color::colorize('Stable', 'green') : Color::colorize('Unstable', 'red');
    echo sprintf("%-25s: %s\n", $algorithm, $status);
}

// Algorithm characteristics summary
echo "\n" . Color::bold("📋 Algorithm Characteristics Summary") . "\n";
echo str_repeat("=", 50) . "\n";

$characteristics = [
    Engine::TIM_SORT => ['Stable' => 'Yes', 'In-Place' => 'No', 'Best For' => 'General purpose'],
    Engine::PATTERN_DEFEATING_QUICKSORT => ['Stable' => 'No', 'In-Place' => 'Yes', 'Best For' => 'Partially sorted data'],
    Engine::DUAL_PIVOT_QUICKSORT => ['Stable' => 'No', 'In-Place' => 'Yes', 'Best For' => 'Java-style performance'],
    Engine::GRAIL_SORT => ['Stable' => 'Yes', 'In-Place' => 'Yes', 'Best For' => 'Memory-constrained environments'],
    Engine::PDQ_SORT_BRANCHLESS => ['Stable' => 'No', 'In-Place' => 'Yes', 'Best For' => 'Uniform key distributions'],
    Engine::BITONIC_SORT => ['Stable' => 'No', 'In-Place' => 'Yes', 'Best For' => 'GPU/parallel processing'],
    Engine::FLASH_SORT => ['Stable' => 'No', 'In-Place' => 'Yes', 'Best For' => 'Numeric keys, uniform distribution'],
    Engine::CYCLE_SORT => ['Stable' => 'No', 'In-Place' => 'Yes', 'Best For' => 'Minimizing writes']
];

foreach ($characteristics as $algorithm => $props) {
    echo sprintf("%-25s: ", $algorithm);
    foreach ($props as $prop => $value) {
        echo "{$prop}: {$value} | ";
    }
    echo "\n";
}

echo "\n" . Color::gradient("✨ Benchmarking complete! Use these results to choose the best algorithm for your use case.", '#4ecdc4', '#ff6b6b') . "\n";
echo "Run 'php examples/sorting_benchmarks.php' to execute these benchmarks again.\n";
