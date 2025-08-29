<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use Phastron\Security\SecureToken;
use Phastron\Utility\Validator;
use Phastron\Utility\StringHelper;
use Phastron\Utility\Slug;
use Phastron\Tools\Stopwatch;
use Phastron\Cli\Color;

echo Color::gradient("🔐 Phastron Security & Utilities Demo", '#ff6b6b', '#4ecdc4') . "\n\n";

// 1. Secure Token Generation
echo Color::bold("1. Secure Token Generation:\n");
echo str_repeat("=", 50) . "\n";

// Basic token types
echo "Basic Token Types:\n";
echo "  Random (32 bytes): " . SecureToken::generate(32) . "\n";
echo "  URL-safe (16 chars): " . SecureToken::urlSafe(16) . "\n";
echo "  Numeric (8 digits): " . SecureToken::numeric(8) . "\n";
echo "  Alphanumeric (12 chars): " . SecureToken::alphanumeric(12) . "\n";
echo "  Mixed (20 chars): " . SecureToken::mixed(20) . "\n\n";

// 2. Advanced Token Generation
echo Color::bold("2. Advanced Token Generation:\n");
echo str_repeat("=", 50) . "\n";

// Entropy-based tokens
echo "Entropy-based Tokens:\n";
$entropyLevels = [64, 128, 256];
foreach ($entropyLevels as $entropy) {
    $token = SecureToken::withEntropy($entropy);
    $strength = SecureToken::verifyStrength($token);
    echo "  {$entropy}-bit entropy: {$token}\n";
    echo "    Strength: {$strength['strength_score']}% | Variety: " . 
         round($strength['character_variety'] * 100, 1) . "%\n";
}

// Pattern-based tokens
echo "\nPattern-based Tokens:\n";
$patterns = [
    'XXXX-XXXX-XXXX' => 'Standard format',
    'XX-XX-XX-XX' => 'Compact format',
    'XXXXX-XXXXX' => 'Long format',
    'XX-XXXX-XX' => 'Mixed format',
    'REQ-XXXX-XXXX' => 'Request ID format'
];

foreach ($patterns as $pattern => $description) {
    $token = SecureToken::pattern($pattern);
    echo "  {$description}: {$token}\n";
}

// Strong token generation
echo "\nStrong Token Generation:\n";
try {
    $strongToken = SecureToken::strong(256);
    echo "  Generated strong token: {$strongToken}\n";
} catch (Exception $e) {
    echo "  Error: " . $e->getMessage() . "\n";
}

echo "\n";

// 3. Token Strength Analysis
echo Color::bold("3. Token Strength Analysis:\n");
echo str_repeat("=", 50) . "\n";

$testTokens = [
    'weak123' => 'Weak password',
    'StrongP@ssw0rd!' => 'Strong password',
    SecureToken::generate(16) => 'Random 16 bytes',
    SecureToken::urlSafe(32) => 'URL-safe 32 chars',
    SecureToken::withEntropy(128) => '128-bit entropy'
];

foreach ($testTokens as $token => $description) {
    $strength = SecureToken::verifyStrength($token);
    echo "Token: {$description}\n";
    echo "  Value: {$token}\n";
    echo "  Length: {$strength['length']} characters\n";
    echo "  Entropy: {$strength['entropy_bits']} bits\n";
    echo "  Character variety: " . round($strength['character_variety'] * 100, 1) . "%\n";
    echo "  Strength score: {$strength['strength_score']}%\n";
    echo "  Is strong: " . ($strength['is_strong'] ? 'Yes' : 'No') . "\n\n";
}

// 4. Validation Examples
echo Color::bold("4. Validation Examples:\n");
echo str_repeat("=", 50) . "\n";

// IP address validation
echo "IP Address Validation:\n";
$ipAddresses = [
    '192.168.1.1' => 'Private IPv4',
    '10.0.0.1' => 'Private IPv4',
    '172.16.0.1' => 'Private IPv4',
    '8.8.8.8' => 'Public IPv4',
    '::1' => 'IPv6 localhost',
    '2001:db8::1' => 'IPv6 documentation',
    'invalid.ip' => 'Invalid IP',
    '256.256.256.256' => 'Invalid IPv4 range'
];

foreach ($ipAddresses as $ip => $description) {
    $isValid = Validator::isValidIP($ip);
    $isValidV4 = Validator::isValidIPv4($ip);
    $isValidV6 = Validator::isValidIPv6($ip);
    
    echo "  {$description} '{$ip}':\n";
    echo "    Valid IP: " . ($isValid ? '✓' : '✗') . "\n";
    echo "    Valid IPv4: " . ($isValidV4 ? '✓' : '✗') . "\n";
    echo "    Valid IPv6: " . ($isValidV6 ? '✓' : '✗') . "\n";
}

// Format validation
echo "\nFormat Validation:\n";
$formats = [
    'user@example.com' => 'Email',
    'https://github.com/makalin/phastron' => 'URL',
    '{"key": "value", "number": 42}' => 'JSON',
    'Hello World!' => 'Text'
];

foreach ($formats as $value => $type) {
    $isValidEmail = Validator::isValidEmail($value);
    $isValidURL = Validator::isValidURL($value);
    $isValidJSON = Validator::isValidJSON($value);
    
    echo "  {$type} '{$value}':\n";
    echo "    Valid Email: " . ($isValidEmail ? '✓' : '✗') . "\n";
    echo "    Valid URL: " . ($isValidURL ? '✓' : '✗') . "\n";
    echo "    Valid JSON: " . ($isValidJSON ? '✓' : '✗') . "\n";
}

// String validation
echo "\nString Validation:\n";
$strings = [
    'Hello123' => 'Alphanumeric',
    'Hello' => 'Alphabetic',
    '12345' => 'Numeric',
    'Hello World' => 'With spaces',
    'Hello-World_123' => 'Mixed characters'
];

foreach ($strings as $string => $description) {
    echo "  {$description} '{$string}':\n";
    echo "    Alphanumeric: " . (Validator::isAlphanumeric($string) ? '✓' : '✗') . "\n";
    echo "    Alphabetic: " . (Validator::isAlphabetic($string) ? '✓' : '✗') . "\n";
    echo "    Numeric: " . (Validator::isNumeric($string) ? '✓' : '✗') . "\n";
    echo "    Length 3-20: " . (Validator::isLengthBetween($string, 3, 20) ? '✓' : '✗') . "\n";
}

// Pattern matching
echo "\nPattern Matching:\n";
$patterns = [
    '/^[A-Z][a-z]+$/' => 'Capitalized word',
    '/^\d{3}-\d{3}-\d{4}$/' => 'Phone number format',
    '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/' => 'Email format'
];

$testStrings = [
    'Hello' => 'Capitalized word',
    '123-456-7890' => 'Phone number',
    'user@example.com' => 'Email address',
    'hello' => 'Lowercase word',
    'invalid-phone' => 'Invalid phone'
];

foreach ($testStrings as $string => $description) {
    echo "  {$description} '{$string}':\n";
    foreach ($patterns as $pattern => $patternDesc) {
        $matches = Validator::matchesPattern($string, $pattern);
        echo "    {$patternDesc}: " . ($matches ? '✓' : '✗') . "\n";
    }
}

echo "\n";

// 5. String Utilities
echo Color::bold("5. String Utilities:\n");
echo str_repeat("=", 50) . "\n";

// Case conversion
echo "Case Conversion:\n";
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
    echo "  '{$input}' → {$style}: '{$result}'\n";
}

// String analysis
echo "\nString Analysis:\n";
$text = "The quick brown fox jumps over the lazy dog. It was a beautiful day.";
echo "  Text: '{$text}'\n";
echo "  Words: " . StringHelper::wordCount($text) . "\n";
echo "  Characters: " . StringHelper::charCount($text) . "\n";
echo "  Sentences: " . StringHelper::sentenceCount($text) . "\n";
echo "  First sentence: '" . StringHelper::extractFirstSentence($text) . "'\n";

// Palindrome examples
echo "\nPalindrome Detection:\n";
$palindromes = ['racecar', 'deed', 'level', 'hello', 'A man a plan a canal Panama'];
foreach ($palindromes as $word) {
    $clean = preg_replace('/[^a-zA-Z0-9]/', '', strtolower($word));
    $isPalindrome = StringHelper::isPalindrome($clean);
    echo "  '{$word}': " . ($isPalindrome ? '✓ Palindrome' : '✗ Not palindrome') . "\n";
}

// Pluralization
echo "\nPluralization:\n";
$words = ['cat', 'dog', 'child', 'person', 'fish'];
$counts = [1, 5, 3, 2, 10];

foreach ($words as $index => $word) {
    $count = $counts[$index];
    $plural = StringHelper::autoPluralize($word, $count);
    echo "  {$count} {$word} → {$plural}\n";
}

echo "\n";

// 6. Slug Generation
echo Color::bold("6. Slug Generation:\n");
echo str_repeat("=", 50) . "\n";

// Basic slug generation
echo "Basic Slug Generation:\n";
$titles = [
    'Getting Started with PHP 8.3',
    'Advanced Sorting Algorithms',
    'Building Scalable Web Applications',
    'Machine Learning in PHP',
    'Performance Optimization Techniques'
];

foreach ($titles as $title) {
    $slug = Slug::create($title);
    echo "  '{$title}' → '{$slug}'\n";
}

// Multi-language support
echo "\nMulti-language Support:\n";
$multilingual = [
    'Hello World!' => 'English',
    'Привет мир!' => 'Russian',
    'こんにちは世界！' => 'Japanese',
    'مرحبا بالعالم!' => 'Arabic',
    '你好世界！' => 'Chinese',
    '안녕하세요 세계!' => 'Korean'
];

foreach ($multilingual as $text => $language) {
    $slug = Slug::create($text);
    echo "  {$language}: '{$text}' → '{$slug}'\n";
}

// Custom slug options
echo "\nCustom Slug Options:\n";
$customText = 'This is a very long text that needs to be truncated';
$slug1 = Slug::create($customText, '-', 30);
$slug2 = Slug::create($customText, '_', 50);

echo "  Original: '{$customText}'\n";
echo "  Truncated to 30 chars: '{$slug1}'\n";
echo "  Truncated to 50 chars: '{$slug2}'\n";

// Custom transliteration rules
echo "\nCustom Transliteration:\n";
$customRules = ['PHP' => 'php', 'API' => 'api', 'SQL' => 'sql'];
$customText = 'PHP API SQL Database';
$customSlug = Slug::createCustom($customText, $customRules);

echo "  Original: '{$customText}'\n";
echo "  Custom rules: " . json_encode($customRules) . "\n";
echo "  Result: '{$customSlug}'\n";

echo "\n";

// 7. Performance Testing
echo Color::bold("7. Performance Testing:\n");
echo str_repeat("=", 50) . "\n";

// Token generation performance
echo "Token Generation Performance:\n";
$iterations = 1000;

$stopwatch = Stopwatch::startNew();
for ($i = 0; $i < $iterations; $i++) {
    SecureToken::generate(16);
}
$stopwatch->stop();
echo "  Generate {$iterations} random tokens: " . $stopwatch->getFormattedTime() . "\n";

$stopwatch = Stopwatch::startNew();
for ($i = 0; $i < $iterations; $i++) {
    SecureToken::urlSafe(16);
}
$stopwatch->stop();
echo "  Generate {$iterations} URL-safe tokens: " . $stopwatch->getFormattedTime() . "\n";

// Validation performance
echo "\nValidation Performance:\n";
$testEmails = array_fill(0, $iterations, 'user@example.com');
$testIPs = array_fill(0, $iterations, '192.168.1.1');

$stopwatch = Stopwatch::startNew();
foreach ($testEmails as $email) {
    Validator::isValidEmail($email);
}
$stopwatch->stop();
echo "  Validate {$iterations} emails: " . $stopwatch->getFormattedTime() . "\n";

$stopwatch = Stopwatch::startNew();
foreach ($testIPs as $ip) {
    Validator::isValidIP($ip);
}
$stopwatch->stop();
echo "  Validate {$iterations} IPs: " . $stopwatch->getFormattedTime() . "\n";

// Slug generation performance
echo "\nSlug Generation Performance:\n";
$testTitles = array_fill(0, $iterations, 'This is a test title for performance testing');

$stopwatch = Stopwatch::startNew();
foreach ($testTitles as $title) {
    Slug::create($title);
}
$stopwatch->stop();
echo "  Generate {$iterations} slugs: " . $stopwatch->getFormattedTime() . "\n";

echo "\n";

// 8. Real-world Use Cases
echo Color::bold("8. Real-world Use Cases:\n");
echo str_repeat("=", 50) . "\n";

// API token generation
echo "API Token Generation:\n";
$apiTokens = [
    'access_token' => SecureToken::urlSafe(32),
    'refresh_token' => SecureToken::urlSafe(64),
    'session_id' => SecureToken::alphanumeric(16),
    'request_id' => SecureToken::pattern('REQ-XXXX-XXXX-XXXX'),
    'webhook_secret' => SecureToken::generate(32)
];

foreach ($apiTokens as $type => $token) {
    echo "  {$type}: {$token}\n";
}

// User input validation
echo "\nUser Input Validation:\n";
$userInputs = [
    'email' => 'user@example.com',
    'ip' => '192.168.1.1',
    'url' => 'https://example.com',
    'username' => 'john_doe123'
];

foreach ($userInputs as $field => $value) {
    $valid = false;
    switch ($field) {
        case 'email':
            $valid = Validator::isValidEmail($value);
            break;
        case 'ip':
            $valid = Validator::isValidIP($value);
            break;
        case 'url':
            $valid = Validator::isValidURL($value);
            break;
        case 'username':
            $valid = Validator::isAlphanumeric($value) && Validator::isLengthBetween($value, 3, 20);
            break;
    }
    
    $status = $valid ? '✓ Valid' : '✗ Invalid';
    echo "  {$field}: '{$value}' - {$status}\n";
}

// Content management system
echo "\nContent Management System:\n";
$articles = [
    'Getting Started with PHP 8.3',
    'Advanced Sorting Algorithms',
    'Building Scalable Web Applications'
];

echo "Article slugs:\n";
foreach ($articles as $title) {
    $slug = Slug::create($title);
    echo "  '{$title}' → /articles/{$slug}\n";
}

echo "\n" . Color::gradient("🔐 Security & utilities demo complete!", '#4ecdc4', '#ff6b6b') . "\n";
echo "Run 'php examples/security_utilities.php' to see this demo again.\n";
