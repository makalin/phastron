<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use Phastron\Struct\BloomFilter;
use Phastron\Struct\ImmutableArray;
use Phastron\Tools\Stopwatch;
use Phastron\Cli\Color;

echo Color::gradient("🏗️ Phastron Data Structures Demo", '#4ecdc4', '#ff6b6b') . "\n\n";

// 1. Bloom Filter Examples
echo Color::bold("1. Bloom Filter Examples:\n");
echo str_repeat("=", 50) . "\n";

// Small Bloom filter for demonstration
$smallBF = BloomFilter::init(100, 0.01);
echo "Created Bloom filter for 100 items with 1% false positive rate\n";

// Add some items
$items = ['apple', 'banana', 'cherry', 'date', 'elderberry'];
foreach ($items as $item) {
    $smallBF->add($item);
    echo "Added: {$item}\n";
}

// Test membership
$testItems = ['apple', 'banana', 'orange', 'grape', 'cherry'];
foreach ($testItems as $item) {
    $exists = $smallBF->mightContain($item);
    $status = $exists ? 'Probably exists' : 'Definitely not';
    echo "Item '{$item}': {$status}\n";
}

// Get statistics
$stats = $smallBF->getStats();
echo "\nBloom Filter Statistics:\n";
echo "  Size: " . number_format($stats['size']) . " bits\n";
echo "  Hash functions: " . $stats['hash_count'] . "\n";
echo "  Fill ratio: " . round($stats['fill_ratio'] * 100, 2) . "%\n";
echo "  Estimated false positive rate: " . round($stats['estimated_false_positive_rate'] * 100, 4) . "%\n\n";

// 2. Large Scale Bloom Filter
echo Color::bold("2. Large Scale Bloom Filter:\n");
echo str_repeat("=", 50) . "\n";

$largeBF = BloomFilter::init(100000, 0.001);
echo "Created Bloom filter for 100,000 items with 0.1% false positive rate\n";

// Add many items
$start = microtime(true);
for ($i = 0; $i < 50000; $i++) {
    $largeBF->add("user_" . $i);
}
$end = microtime(true);

echo "Added 50,000 items in " . round(($end - $start) * 1000, 2) . " ms\n";

// Test performance
$start = microtime(true);
$found = 0;
for ($i = 0; $i < 10000; $i++) {
    if ($largeBF->mightContain("user_" . random_int(0, 99999))) {
        $found++;
    }
}
$end = microtime(true);

echo "Looked up 10,000 items in " . round(($end - $start) * 1000, 2) . " ms\n";
echo "Found: {$found} items\n";

$stats = $largeBF->getStats();
echo "Current fill ratio: " . round($stats['fill_ratio'] * 100, 2) . "%\n\n";

// 3. Bloom Filter Persistence
echo Color::bold("3. Bloom Filter Persistence:\n");
echo str_repeat("=", 50) . "\n";

// Save to file
$filename = 'test_bloom_filter.bf';
$smallBF->toFile($filename);
echo "Saved Bloom filter to '{$filename}'\n";

// Load from file
$loadedBF = BloomFilter::fromFile($filename);
echo "Loaded Bloom filter from '{$filename}'\n";

// Verify data integrity
$testItem = 'apple';
$original = $smallBF->mightContain($testItem);
$loaded = $loadedBF->mightContain($testItem);

echo "Data integrity check for '{$testItem}': " . 
     ($original === $loaded ? 'PASS' : 'FAIL') . "\n";

// Clean up
unlink($filename);
echo "Cleaned up test file\n\n";

// 4. Immutable Array Basic Operations
echo Color::bold("4. Immutable Array Basic Operations:\n");
echo str_repeat("=", 50) . "\n";

$array = ImmutableArray::from([1, 2, 3, 4, 5, 6, 7, 8, 9, 10]);
echo "Original array: " . implode(', ', $array->toArray()) . "\n";

// Basic transformations
$doubled = $array->map(function($n) { return $n * 2; });
echo "Doubled: " . implode(', ', $doubled->toArray()) . "\n";

$evens = $array->filter(function($n) { return $n % 2 === 0; });
echo "Even numbers: " . implode(', ', $evens->toArray()) . "\n";

$sum = $array->reduce(function($carry, $item) { return $carry + $item; }, 0);
echo "Sum: {$sum}\n";

$reversed = $array->reverse();
echo "Reversed: " . implode(', ', $reversed->toArray()) . "\n\n";

// 5. Immutable Array Advanced Operations
echo Color::bold("5. Immutable Array Advanced Operations:\n");
echo str_repeat("=", 50) . "\n";

// Complex chaining
$result = $array
    ->filter(function($n) { return $n > 3; })
    ->map(function($n) { return $n * $n; })
    ->filter(function($n) { return $n < 50; })
    ->sort()
    ->take(3);

echo "Complex operation result: " . implode(', ', $result->toArray()) . "\n";

// Utility methods
$range = ImmutableArray::range(1, 20, 2);
echo "Range 1-20 step 2: " . implode(', ', $range->toArray()) . "\n";

$repeated = ImmutableArray::repeat('x', 5);
echo "Repeated 'x' 5 times: " . implode(', ', $repeated->toArray()) . "\n";

$chunked = $range->chunk(4);
echo "Chunked into groups of 4: " . json_encode($chunked->toArray()) . "\n\n";

// 6. Immutable Array Functional Operations
echo Color::bold("6. Immutable Array Functional Operations:\n");
echo str_repeat("=", 50) . "\n";

$data = ImmutableArray::from([
    'apple' => 5,
    'banana' => 3,
    'cherry' => 8,
    'date' => 2,
    'elderberry' => 1
]);

echo "Original data: " . json_encode($data->toArray()) . "\n";

// Extract values and process
$processed = $data
    ->values()
    ->filter(function($n) { return $n > 2; })
    ->map(function($n) { return $n * 2; })
    ->sort()
    ->reverse();

echo "Processed values: " . implode(', ', $processed->toArray()) . "\n";

// Check conditions
$allPositive = $data->all(function($n) { return $n > 0; });
$anyLarge = $data->any(function($n) { return $n > 5; });
$firstLarge = $data->find(function($n) { return $n > 5; });

echo "All positive: " . ($allPositive ? 'Yes' : 'No') . "\n";
echo "Any large (>5): " . ($anyLarge ? 'Yes' : 'No') . "\n";
echo "First large (>5): " . ($firstLarge ?: 'None') . "\n\n";

// 7. Performance Comparison
echo Color::bold("7. Performance Comparison:\n");
echo str_repeat("=", 50) . "\n";

$testSizes = [1000, 10000, 100000];
$testData = [];

foreach ($testSizes as $size) {
    $testData[$size] = range(1, $size);
}

// Test traditional array operations
echo "Traditional Array Operations:\n";
foreach ($testSizes as $size) {
    $data = $testData[$size];
    
    $start = microtime(true);
    $filtered = array_filter($data, function($n) { return $n % 2 === 0; });
    $mapped = array_map(function($n) { return $n * 2; }, $filtered);
    $end = microtime(true);
    
    $time = ($end - $start) * 1000;
    echo "  Size {$size}: " . round($time, 2) . " ms\n";
}

// Test ImmutableArray operations
echo "\nImmutableArray Operations:\n";
foreach ($testSizes as $size) {
    $data = ImmutableArray::from($testData[$size]);
    
    $start = microtime(true);
    $result = $data
        ->filter(function($n) { return $n % 2 === 0; })
        ->map(function($n) { return $n * 2; });
    $end = microtime(true);
    
    $time = ($end - $start) * 1000;
    echo "  Size {$size}: " . round($time, 2) . " ms\n";
}

echo "\n";

// 8. Memory Usage Analysis
echo Color::bold("8. Memory Usage Analysis:\n");
echo str_repeat("=", 50) . "\n";

$testSize = 10000;
$testArray = range(1, $testSize);

// Traditional array
$memoryBefore = memory_get_usage();
$traditional = array_map(function($n) { return $n * 2; }, $testArray);
$memoryAfter = memory_get_usage();
$traditionalMemory = $memoryAfter - $memoryBefore;

// ImmutableArray
$memoryBefore = memory_get_usage();
$immutable = ImmutableArray::from($testArray)->map(function($n) { return $n * 2; });
$memoryAfter = memory_get_usage();
$immutableMemory = $memoryAfter - $memoryBefore;

echo "Traditional array memory usage: " . number_format($traditionalMemory) . " bytes\n";
echo "ImmutableArray memory usage: " . number_format($immutableMemory) . " bytes\n";
echo "Memory difference: " . number_format($immutableMemory - $traditionalMemory) . " bytes\n\n";

// 9. Real-world Use Cases
echo Color::bold("9. Real-world Use Cases:\n");
echo str_repeat("=", 50) . "\n";

// User management system
echo "User Management System:\n";
$userBF = BloomFilter::init(10000, 0.001);
$users = ['john_doe', 'jane_smith', 'admin', 'guest', 'moderator'];

foreach ($users as $user) {
    $userBF->add($user);
}

$testUsers = ['john_doe', 'jane_smith', 'hacker', 'new_user'];
foreach ($testUsers as $user) {
    $exists = $userBF->mightContain($user);
    echo "  User '{$user}': " . ($exists ? 'Found' : 'Not found') . "\n";
}

// Data processing pipeline
echo "\nData Processing Pipeline:\n";
$rawData = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15];
$data = ImmutableArray::from($rawData);

$processed = $data
    ->filter(function($n) { return $n % 2 === 0; })  // Even numbers only
    ->map(function($n) { return $n * $n; })           // Square them
    ->filter(function($n) { return $n > 20; })        // Greater than 20
    ->sort()                                          // Sort ascending
    ->take(5);                                        // Take first 5

echo "Original data: " . implode(', ', $rawData) . "\n";
echo "Processed data: " . implode(', ', $processed->toArray()) . "\n\n";

// 10. Error Handling and Edge Cases
echo Color::bold("10. Error Handling and Edge Cases:\n");
echo str_repeat("=", 50) . "\n";

// Empty array operations
$empty = ImmutableArray::from([]);
echo "Empty array operations:\n";
echo "  Is empty: " . ($empty->isEmpty() ? 'Yes' : 'No') . "\n";
echo "  Count: " . $empty->count() . "\n";
echo "  First: " . ($empty->first() ?: 'null') . "\n";
echo "  Last: " . ($empty->last() ?: 'null') . "\n";

// Single element array
$single = ImmutableArray::from([42]);
echo "\nSingle element array:\n";
echo "  First: " . $single->first() . "\n";
echo "  Last: " . $single->last() . "\n";
echo "  Take 3: " . implode(', ', $single->take(3)->toArray()) . "\n";

// Large number operations
$large = ImmutableArray::from([PHP_INT_MAX, PHP_INT_MIN, 0]);
echo "\nLarge number operations:\n";
echo "  Max: " . $large->reduce(function($carry, $item) { 
    return $carry > $item ? $carry : $item; 
}) . "\n";
echo "  Min: " . $large->reduce(function($carry, $item) { 
    return $carry < $item ? $carry : $item; 
}) . "\n";

echo "\n" . Color::gradient("🏗️ Data structures demo complete!", '#ff6b6b', '#4ecdc4') . "\n";
echo "Run 'php examples/data_structures.php' to see this demo again.\n";
