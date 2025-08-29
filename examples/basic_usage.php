<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use Phastron\Sort\Engine;
use Phastron\Cli\Color;
use Phastron\Struct\BloomFilter;
use Phastron\Struct\ImmutableArray;
use Phastron\Utility\Slug;
use Phastron\Security\SecureToken;
use Phastron\Tools\Stopwatch;
use Phastron\Utility\Validator;
use Phastron\Utility\StringHelper;

echo Color::gradient("🚀 Phastron - The Ultimate PHP Utility Arsenal", '#ff007f', '#00c6ff') . "\n\n";

// 1. Sorting Examples
echo Color::bold("📊 Sorting Examples:\n");
$array = [64, 34, 25, 12, 22, 11, 90];
echo "Original array: " . implode(', ', $array) . "\n";

$stopwatch = Stopwatch::startNew();
$sorted = Engine::sort($array, Engine::TIM_SORT);
$stopwatch->stop();

echo "Sorted with TimSort: " . implode(', ', $sorted) . "\n";
echo "Sorting took: " . $stopwatch->getFormattedTime() . "\n\n";

// 2. CLI Colors
echo Color::bold("🎨 CLI Colors:\n");
echo Color::colorize("This is red text", 'red') . "\n";
echo Color::background("This has blue background", 'blue') . "\n";
echo Color::bold("This is bold text") . "\n";
echo Color::gradient("This is a gradient!", '#ff6b6b', '#4ecdc4') . "\n\n";

// 3. Bloom Filter
echo Color::bold("🔍 Bloom Filter:\n");
$bf = BloomFilter::init(1000, 0.01);
$bf->add('phastron');
$bf->add('php');
$bf->add('utilities');

echo "Contains 'phastron': " . ($bf->mightContain('phastron') ? 'Yes' : 'No') . "\n";
echo "Contains 'python': " . ($bf->mightContain('python') ? 'Yes' : 'No') . "\n";
echo "False positive rate: " . round($bf->getFalsePositiveRate() * 100, 2) . "%\n\n";

// 4. Immutable Array
echo Color::bold("📝 Immutable Array:\n");
$arr = ImmutableArray::from([1, 2, 3, 4, 5, 6, 7, 8, 9, 10]);
$result = $arr->map(fn($n) => $n * 2)
              ->filter(fn($n) => $n > 10)
              ->take(3);

echo "Original: " . implode(', ', $arr->toArray()) . "\n";
echo "Mapped, filtered, and limited: " . implode(', ', $result->toArray()) . "\n\n";

// 5. Slug Generation
echo Color::bold("🔗 Slug Generation:\n");
$texts = [
    'Hello World!',
    'Привет мир!',
    'こんにちは世界！',
    'مرحبا بالعالم!'
];

foreach ($texts as $text) {
    $slug = Slug::create($text);
    echo "'{$text}' → '{$slug}'\n";
}
echo "\n";

// 6. Secure Tokens
echo Color::bold("🔐 Secure Tokens:\n");
echo "Random token: " . SecureToken::generate(16) . "\n";
echo "URL-safe token: " . SecureToken::urlSafe(16) . "\n";
echo "Numeric token: " . SecureToken::numeric(8) . "\n";
echo "Pattern token: " . SecureToken::pattern('XXXX-XXXX-XXXX') . "\n\n";

// 7. Validation
echo Color::bold("✅ Validation:\n");
$testData = [
    'ip' => '192.168.1.1',
    'email' => 'test@example.com',
    'url' => 'https://github.com/makalin/phastron',
    'string' => 'Hello123'
];

foreach ($testData as $type => $value) {
    $method = 'isValid' . ucfirst($type === 'ip' ? 'IP' : $type);
    if (method_exists(Validator::class, $method)) {
        $isValid = Validator::$method($value);
        echo ucfirst($type) . " '{$value}': " . ($isValid ? 'Valid' : 'Invalid') . "\n";
    }
}
echo "\n";

// 8. String Utilities
echo Color::bold("📝 String Utilities:\n");
$word = 'cat';
echo "Plural of '{$word}': " . StringHelper::autoPluralize($word, 5) . "\n";
echo "Title case: " . StringHelper::toTitleCase('hello world') . "\n";
echo "Camel case: " . StringHelper::toCamelCase('hello world') . "\n";
echo "Snake case: " . StringHelper::toSnakeCase('Hello World') . "\n";
echo "Kebab case: " . StringHelper::toKebabCase('Hello World') . "\n";
echo "Palindrome check 'racecar': " . (StringHelper::isPalindrome('racecar') ? 'Yes' : 'No') . "\n\n";

// 9. Advanced Sorting Algorithm Comparison
echo Color::bold("🏁 Advanced Sorting Algorithm Comparison:\n");
$testArray = range(1, 1000);
shuffle($testArray);

$algorithms = [
    Engine::TIM_SORT,
    Engine::PATTERN_DEFEATING_QUICKSORT,
    Engine::DUAL_PIVOT_QUICKSORT,
    Engine::GRAIL_SORT
];

foreach ($algorithms as $algorithm) {
    $testArrayCopy = $testArray;
    $stopwatch = Stopwatch::startNew();
    $sorted = Engine::sort($testArrayCopy, $algorithm);
    $stopwatch->stop();
    
    echo sprintf("%-30s: %s\n", $algorithm, $stopwatch->getFormattedTime());
}
echo "\n";

// 10. Advanced Bloom Filter Operations
echo Color::bold("🔍 Advanced Bloom Filter Operations:\n");
$largeBF = BloomFilter::init(10000, 0.001);

// Add many items
$items = [];
for ($i = 0; $i < 1000; $i++) {
    $item = "user_" . $i;
    $items[] = $item;
    $largeBF->add($item);
}

// Test membership
$testItems = ['user_500', 'user_999', 'user_1500', 'nonexistent_user'];
foreach ($testItems as $item) {
    $exists = $largeBF->mightContain($item);
    echo "Item '{$item}': " . ($exists ? 'Probably exists' : 'Definitely not') . "\n";
}

$stats = $largeBF->getStats();
echo "Bloom Filter Stats:\n";
echo "  Size: " . number_format($stats['size']) . " bits\n";
echo "  Hash functions: " . $stats['hash_count'] . "\n";
echo "  Fill ratio: " . round($stats['fill_ratio'] * 100, 2) . "%\n";
echo "  Estimated false positive rate: " . round($stats['estimated_false_positive_rate'] * 100, 4) . "%\n\n";

// 11. Advanced Immutable Array Operations
echo Color::bold("📝 Advanced Immutable Array Operations:\n");
$complexArray = ImmutableArray::from([
    'apple' => 5,
    'banana' => 3,
    'cherry' => 8,
    'date' => 2,
    'elderberry' => 1
]);

echo "Original array: " . json_encode($complexArray->toArray()) . "\n";

// Complex chaining
$result = $complexArray
    ->values()
    ->filter(fn($n) => $n > 2)
    ->map(fn($n) => $n * 2)
    ->sort()
    ->reverse()
    ->take(3);

echo "Complex operation result: " . implode(', ', $result->toArray()) . "\n";

// Range and utility operations
$range = ImmutableArray::range(1, 20, 2);
echo "Range 1-20 step 2: " . implode(', ', $range->toArray()) . "\n";

$repeated = ImmutableArray::repeat('x', 5);
echo "Repeated 'x' 5 times: " . implode(', ', $repeated->toArray()) . "\n";

$chunked = $range->chunk(4);
echo "Chunked into groups of 4: " . json_encode($chunked->toArray()) . "\n\n";

// 12. Advanced String Operations
echo Color::bold("📝 Advanced String Operations:\n");

// Case conversion examples
$caseExamples = [
    'hello world' => 'camelCase',
    'Hello World' => 'snake_case',
    'hello_world' => 'kebab-case',
    'HELLO WORLD' => 'titleCase'
];

foreach ($caseExamples as $input => $style) {
    switch ($style) {
        case 'camelCase':
            $result = StringHelper::toCamelCase($input);
            break;
        case 'snake_case':
            $result = StringHelper::toSnakeCase($input);
            break;
        case 'kebab-case':
            $result = StringHelper::toKebabCase($input);
            break;
        case 'titleCase':
            $result = StringHelper::toTitleCase($input);
            break;
    }
    echo "'{$input}' → {$style}: '{$result}'\n";
}

// String analysis
$text = "The quick brown fox jumps over the lazy dog. It was a beautiful day.";
echo "\nText analysis:\n";
echo "  Words: " . StringHelper::wordCount($text) . "\n";
echo "  Characters: " . StringHelper::charCount($text) . "\n";
echo "  Sentences: " . StringHelper::sentenceCount($text) . "\n";
echo "  First sentence: '" . StringHelper::extractFirstSentence($text) . "'\n";

// Palindrome examples
$palindromes = ['racecar', 'deed', 'level', 'hello', 'A man a plan a canal Panama'];
echo "\nPalindrome checks:\n";
foreach ($palindromes as $word) {
    $clean = preg_replace('/[^a-zA-Z0-9]/', '', strtolower($word));
    $isPalindrome = StringHelper::isPalindrome($clean);
    echo "  '{$word}': " . ($isPalindrome ? 'Yes' : 'No') . "\n";
}
echo "\n";

// 13. Advanced Secure Token Generation
echo Color::bold("🔐 Advanced Secure Token Generation:\n");

// Generate tokens with different entropy requirements
$entropyLevels = [64, 128, 256];
foreach ($entropyLevels as $entropy) {
    $token = SecureToken::withEntropy($entropy);
    $strength = SecureToken::verifyStrength($token);
    echo "{$entropy}-bit entropy token: {$token}\n";
    echo "  Strength score: {$strength['strength_score']}%\n";
    echo "  Character variety: " . round($strength['character_variety'] * 100, 1) . "%\n";
}

// Pattern-based tokens
$patterns = [
    'XXXX-XXXX-XXXX' => 'Standard format',
    'XX-XX-XX-XX' => 'Compact format',
    'XXXXX-XXXXX' => 'Long format',
    'XX-XXXX-XX' => 'Mixed format'
];

echo "\nPattern-based tokens:\n";
foreach ($patterns as $pattern => $description) {
    $token = SecureToken::pattern($pattern);
    echo "  {$description}: {$token}\n";
}

// Strong token generation
echo "\nStrong token generation:\n";
try {
    $strongToken = SecureToken::strong(256);
    echo "  Generated strong token: {$strongToken}\n";
} catch (Exception $e) {
    echo "  Error: " . $e->getMessage() . "\n";
}
echo "\n";

// 14. Advanced Validation Examples
echo Color::bold("✅ Advanced Validation Examples:\n");

// IP validation
$ipAddresses = [
    '192.168.1.1' => 'Private IPv4',
    '10.0.0.1' => 'Private IPv4',
    '172.16.0.1' => 'Private IPv4',
    '8.8.8.8' => 'Public IPv4',
    '::1' => 'IPv6 localhost',
    '2001:db8::1' => 'IPv6 documentation',
    'invalid.ip' => 'Invalid IP'
];

foreach ($ipAddresses as $ip => $description) {
    $isValid = Validator::isValidIP($ip);
    $isValidV4 = Validator::isValidIPv4($ip);
    $isValidV6 = Validator::isValidIPv6($ip);
    
    echo "  {$description} '{$ip}':\n";
    echo "    Valid IP: " . ($isValid ? 'Yes' : 'No') . "\n";
    echo "    Valid IPv4: " . ($isValidV4 ? 'Yes' : 'No') . "\n";
    echo "    Valid IPv6: " . ($isValidV6 ? 'Yes' : 'No') . "\n";
}

// String validation
$validationExamples = [
    'Hello123' => 'Alphanumeric',
    'Hello' => 'Alphabetic',
    '12345' => 'Numeric',
    'Hello World' => 'With spaces',
    'Hello-World_123' => 'Mixed characters'
];

echo "\nString validation:\n";
foreach ($validationExamples as $string => $description) {
    echo "  {$description} '{$string}':\n";
    echo "    Alphanumeric: " . (Validator::isAlphanumeric($string) ? 'Yes' : 'No') . "\n";
    echo "    Alphabetic: " . (Validator::isAlphabetic($string) ? 'Yes' : 'No') . "\n";
    echo "    Numeric: " . (Validator::isNumeric($string) ? 'Yes' : 'No') . "\n";
    echo "    Length 3-20: " . (Validator::isLengthBetween($string, 3, 20) ? 'Yes' : 'No') . "\n";
}

// Pattern matching
$patterns = [
    '/^[A-Z][a-z]+$/' => 'Capitalized word',
    '/^\d{3}-\d{3}-\d{4}$/' => 'Phone number format',
    '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/' => 'Email format'
];

$testStrings = [
    'Hello' => 'Capitalized word',
    '123-456-7890' => 'Phone number',
    'user@example.com' => 'Email address'
];

echo "\nPattern matching:\n";
foreach ($testStrings as $string => $description) {
    foreach ($patterns as $pattern => $patternDesc) {
        if (Validator::matchesPattern($string, $pattern)) {
            echo "  '{$string}' matches {$patternDesc}\n";
        }
    }
}
echo "\n";

// 15. Performance Benchmarking
echo Color::bold("⚡ Performance Benchmarking:\n");

// Array sorting performance
$sizes = [100, 1000, 10000];
$algorithms = [Engine::TIM_SORT, Engine::PATTERN_DEFEATING_QUICKSORT];

foreach ($sizes as $size) {
    echo "Array size: " . number_format($size) . "\n";
    
    $array = range(1, $size);
    shuffle($array);
    
    foreach ($algorithms as $algorithm) {
        $stopwatch = Stopwatch::startNew();
        Engine::sort($array, $algorithm);
        $stopwatch->stop();
        
        echo "  {$algorithm}: {$stopwatch->getFormattedTime()}\n";
    }
    echo "\n";
}

// String operation performance
echo "String operation performance:\n";
$longText = str_repeat("The quick brown fox jumps over the lazy dog. ", 1000);

$stopwatch = Stopwatch::startNew();
$slug = Slug::create($longText);
$stopwatch->stop();
echo "  Slug generation: {$stopwatch->getFormattedTime()}\n";

$stopwatch = Stopwatch::startNew();
$wordCount = StringHelper::wordCount($longText);
$stopwatch->stop();
echo "  Word counting: {$stopwatch->getFormattedTime()}\n";

$stopwatch = Stopwatch::startNew();
$charCount = StringHelper::charCount($longText);
$stopwatch->stop();
echo "  Character counting: {$stopwatch->getFormattedTime()}\n\n";

// 16. Real-world Use Cases
echo Color::bold("🌍 Real-world Use Cases:\n");

// User management system
echo "User Management System:\n";
$userBF = BloomFilter::init(100000, 0.001);
$users = ['john_doe', 'jane_smith', 'admin', 'guest', 'moderator'];

foreach ($users as $user) {
    $userBF->add($user);
}

$testUsers = ['john_doe', 'jane_smith', 'hacker', 'new_user'];
foreach ($testUsers as $user) {
    $exists = $userBF->mightContain($user);
    echo "  User '{$user}': " . ($exists ? 'Found' : 'Not found') . "\n";
}

// Content management system
echo "\nContent Management System:\n";
$articles = [
    'Getting Started with PHP 8.3',
    'Advanced Sorting Algorithms',
    'Building Scalable Web Applications',
    'Machine Learning in PHP',
    'Performance Optimization Techniques'
];

echo "Article slugs:\n";
foreach ($articles as $title) {
    $slug = Slug::create($title);
    echo "  '{$title}' → /articles/{$slug}\n";
}

// Data processing pipeline
echo "\nData Processing Pipeline:\n";
$rawData = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15];
$data = ImmutableArray::from($rawData);

$processed = $data
    ->filter(fn($n) => $n % 2 === 0)  // Even numbers only
    ->map(fn($n) => $n * $n)           // Square them
    ->filter(fn($n) => $n > 20)        // Greater than 20
    ->sort()                            // Sort ascending
    ->take(5);                          // Take first 5

echo "Original data: " . implode(', ', $rawData) . "\n";
echo "Processed data: " . implode(', ', $processed->toArray()) . "\n";

// Security token generation for API
echo "\nAPI Security Token Generation:\n";
$apiTokens = [
    'access_token' => SecureToken::urlSafe(32),
    'refresh_token' => SecureToken::urlSafe(64),
    'session_id' => SecureToken::alphanumeric(16),
    'request_id' => SecureToken::pattern('REQ-XXXX-XXXX-XXXX')
];

foreach ($apiTokens as $type => $token) {
    echo "  {$type}: {$token}\n";
}

echo "\n" . Color::gradient("✨ That's Phastron in action!", '#00c6ff', '#ff007f') . "\n";
echo "Check out the README.md for more examples and documentation.\n";
echo "Run 'make example' to execute this demo again.\n";
