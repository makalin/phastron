<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use Phastron\Tools\Stopwatch;
use Phastron\Sort\Engine;
use Phastron\Cli\Color;

echo Color::gradient("⏱️ Phastron Performance Tools Demo", '#4ecdc4', '#ff6b6b') . "\n\n";

// 1. Basic Stopwatch Usage
echo Color::bold("1. Basic Stopwatch Usage:\n");
echo str_repeat("=", 50) . "\n";

$stopwatch = Stopwatch::startNew();
usleep(100000); // Sleep for 0.1 seconds
$stopwatch->stop();

echo "Basic timing: " . $stopwatch->getFormattedTime() . "\n";
echo "Milliseconds: " . $stopwatch->getElapsedMilliseconds() . " ms\n";
echo "Microseconds: " . $stopwatch->getElapsedMicroseconds() . " μs\n\n";

// 2. Lap Timing
echo Color::bold("2. Lap Timing:\n");
echo str_repeat("=", 50) . "\n";

$stopwatch = Stopwatch::startNew();

// Simulate different operations
usleep(50000);  // 0.05 seconds
$stopwatch->lap('Database query');

usleep(30000);  // 0.03 seconds
$stopwatch->lap('File processing');

usleep(20000);  // 0.02 seconds
$stopwatch->lap('API call');

$stopwatch->stop();

echo "Total time: " . $stopwatch->getFormattedTime() . "\n";
echo "Lap times:\n";

foreach ($stopwatch->getLaps() as $lap) {
    echo "  {$lap['label']}: " . round($lap['time'] * 1000, 2) . " ms\n";
}

echo "\n";

// 3. Performance Comparison
echo Color::bold("3. Performance Comparison:\n");
echo str_repeat("=", 50) . "\n";

$testSizes = [1000, 10000, 100000];
$algorithms = [Engine::TIM_SORT, Engine::PATTERN_DEFEATING_QUICKSORT];

foreach ($testSizes as $size) {
    echo "Array size: " . number_format($size) . "\n";
    
    $array = range(1, $size);
    shuffle($array);
    
    foreach ($algorithms as $algorithm) {
        $stopwatch = Stopwatch::startNew();
        Engine::sort($array, $algorithm);
        $stopwatch->stop();
        
        echo "  {$algorithm}: " . $stopwatch->getFormattedTime() . "\n";
    }
    echo "\n";
}

// 4. Function Timing
echo Color::bold("4. Function Timing:\n");
echo str_repeat("=", 50) . "\n";

// Define some test functions
function fibonacci($n) {
    if ($n <= 1) return $n;
    return fibonacci($n - 1) + fibonacci($n - 2);
}

function bubbleSort($array) {
    $n = count($array);
    for ($i = 0; $i < $n - 1; $i++) {
        for ($j = 0; $j < $n - $i - 1; $j++) {
            if ($array[$j] > $array[$j + 1]) {
                [$array[$j], $array[$j + 1]] = [$array[$j + 1], $array[$j]];
            }
        }
    }
    return $array;
}

function generateRandomData($size) {
    $data = [];
    for ($i = 0; $i < $size; $i++) {
        $data[] = random_int(1, 1000);
    }
    return $data;
}

// Time different functions
echo "Function Performance:\n";

// Fibonacci
$result = Stopwatch::time('fibonacci', [20]);
echo "  Fibonacci(20): " . $result['timing']['getFormattedTime']() . "\n";

// Bubble sort
$testArray = generateRandomData(100);
$result = Stopwatch::time('bubbleSort', [$testArray]);
echo "  Bubble sort (100 elements): " . $result['timing']['getFormattedTime']() . "\n";

// Data generation
$result = Stopwatch::time('generateRandomData', [10000]);
echo "  Generate 10,000 random numbers: " . $result['timing']['getFormattedTime']() . "\n";

echo "\n";

// 5. Memory Usage Monitoring
echo Color::bold("5. Memory Usage Monitoring:\n");
echo str_repeat("=", 50) . "\n";

$stopwatch = Stopwatch::startNew();
$memoryBefore = memory_get_usage();

// Create some data
$largeArray = range(1, 100000);
$memoryAfter = memory_get_usage();

$stopwatch->stop();

$memoryUsed = $memoryAfter - $memoryBefore;
echo "Memory usage: " . number_format($memoryUsed) . " bytes (" . 
     round($memoryUsed / 1024, 2) . " KB)\n";
echo "Operation time: " . $stopwatch->getFormattedTime() . "\n";

// Clean up
unset($largeArray);
$memoryAfter = memory_get_usage();
echo "Memory after cleanup: " . number_format($memoryAfter) . " bytes\n\n";

// 6. Continuous Monitoring
echo Color::bold("6. Continuous Monitoring:\n");
echo str_repeat("=", 50) . "\n";

$stopwatch = Stopwatch::startNew();

echo "Starting continuous monitoring...\n";
for ($i = 0; $i < 5; $i++) {
    usleep(200000); // 0.2 seconds
    $stopwatch->lap("Step " . ($i + 1));
    echo "  Completed step " . ($i + 1) . " at " . 
         $stopwatch->getFormattedTime() . "\n";
}

$stopwatch->stop();

echo "Final time: " . $stopwatch->getFormattedTime() . "\n";
echo "All laps:\n";

foreach ($stopwatch->getLaps() as $lap) {
    echo "  {$lap['label']}: " . round($lap['time'] * 1000, 2) . " ms\n";
}

echo "\n";

// 7. Performance Statistics
echo Color::bold("7. Performance Statistics:\n");
echo str_repeat("=", 50) . "\n";

$stopwatch = Stopwatch::startNew();

// Simulate multiple operations with different durations
$operations = [
    'Quick operation' => 10000,    // 0.01 seconds
    'Medium operation' => 100000,  // 0.1 seconds
    'Slow operation' => 500000,    // 0.5 seconds
    'Very slow operation' => 1000000 // 1 second
];

foreach ($operations as $name => $duration) {
    usleep($duration);
    $stopwatch->lap($name);
}

$stopwatch->stop();

$stats = $stopwatch->getStats();
echo "Performance Statistics:\n";
echo "  Total time: " . $stats['getFormattedTime']() . "\n";
echo "  Lap count: " . $stats['lap_count'] . "\n";

if ($stats['lap_count'] > 0) {
    echo "  Fastest lap: " . $stats['fastest_lap']['label'] . 
         " (" . round($stats['fastest_lap']['time'] * 1000, 2) . " ms)\n";
    echo "  Slowest lap: " . $stats['slowest_lap']['label'] . 
         " (" . round($stats['slowest_lap']['time'] * 1000, 2) . " ms)\n";
    echo "  Average lap time: " . round($stats['average_lap_time'] * 1000, 2) . " ms\n";
}

echo "\n";

// 8. Benchmarking Framework
echo Color::bold("8. Benchmarking Framework:\n");
echo str_repeat("=", 50) . "\n";

class BenchmarkRunner {
    private $results = [];
    
    public function run($name, callable $function, $iterations = 1) {
        $times = [];
        
        for ($i = 0; $i < $iterations; $i++) {
            $stopwatch = Stopwatch::startNew();
            $result = $function();
            $stopwatch->stop();
            $times[] = $stopwatch->getElapsedMilliseconds();
        }
        
        $avgTime = array_sum($times) / count($times);
        $minTime = min($times);
        $maxTime = max($times);
        
        $this->results[$name] = [
            'average' => $avgTime,
            'min' => $minTime,
            'max' => $maxTime,
            'iterations' => $iterations
        ];
        
        return $result;
    }
    
    public function getResults() {
        return $this->results;
    }
    
    public function printResults() {
        echo "Benchmark Results:\n";
        foreach ($this->results as $name => $result) {
            echo "  {$name}:\n";
            echo "    Average: " . round($result['average'], 2) . " ms\n";
            echo "    Min: " . round($result['min'], 2) . " ms\n";
            echo "    Max: " . round($result['max'], 2) . " ms\n";
            echo "    Iterations: " . $result['iterations'] . "\n";
        }
    }
}

$benchmark = new BenchmarkRunner();

// Run benchmarks
$benchmark->run('Array operations', function() {
    $array = range(1, 10000);
    $filtered = array_filter($array, function($n) { return $n % 2 === 0; });
    $mapped = array_map(function($n) { return $n * 2; }, $filtered);
    return count($mapped);
}, 5);

$benchmark->run('String operations', function() {
    $text = str_repeat("The quick brown fox jumps over the lazy dog. ", 1000);
    $words = str_word_count($text);
    $chars = strlen($text);
    return [$words, $chars];
}, 5);

$benchmark->run('Math operations', function() {
    $sum = 0;
    for ($i = 0; $i < 100000; $i++) {
        $sum += sqrt($i) * sin($i) * cos($i);
    }
    return $sum;
}, 3);

$benchmark->printResults();

echo "\n";

// 9. Real-world Performance Testing
echo Color::bold("9. Real-world Performance Testing:\n");
echo str_repeat("=", 50) . "\n";

// Database simulation
echo "Database Performance Simulation:\n";
$stopwatch = Stopwatch::startNew();

$stopwatch->lap('Connection established');
usleep(50000); // 0.05 seconds

$stopwatch->lap('Query executed');
usleep(100000); // 0.1 seconds

$stopwatch->lap('Data fetched');
usleep(30000); // 0.03 seconds

$stopwatch->lap('Connection closed');
usleep(10000); // 0.01 seconds

$stopwatch->stop();

echo "Database operation completed in " . $stopwatch->getFormattedTime() . "\n";
echo "Breakdown:\n";

foreach ($stopwatch->getLaps() as $lap) {
    echo "  {$lap['label']}: " . round($lap['time'] * 1000, 2) . " ms\n";
}

echo "\n";

// 10. Performance Optimization Example
echo Color::bold("10. Performance Optimization Example:\n");
echo str_repeat("=", 50) . "\n";

// Inefficient approach
$stopwatch = Stopwatch::startNew();
$result = 0;
for ($i = 0; $i < 100000; $i++) {
    $result += $i;
}
$stopwatch->stop();
$inefficientTime = $stopwatch->getElapsedMilliseconds();

echo "Inefficient loop: " . round($inefficientTime, 2) . " ms\n";

// Efficient approach
$stopwatch = Stopwatch::startNew();
$result = (100000 * 99999) / 2; // Mathematical formula
$stopwatch->stop();
$efficientTime = $stopwatch->getElapsedMilliseconds();

echo "Efficient formula: " . round($efficientTime, 2) . " ms\n";
echo "Speed improvement: " . round($inefficientTime / $efficientTime, 1) . "x faster\n";

echo "\n" . Color::gradient("⏱️ Performance tools demo complete!", '#ff6b6b', '#4ecdc4') . "\n";
echo "Run 'php examples/performance_tools.php' to see this demo again.\n";
