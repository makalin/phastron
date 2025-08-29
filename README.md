# 🚀 **Phastron** – *The Ultimate PHP Utility Arsenal*

[![PHP Version](https://img.shields.io/badge/php-8.3+-blue.svg)](https://php.net)
[![License](https://img.shields.io/badge/license-MIT-green.svg)](LICENSE)
[![Build Status](https://img.shields.io/badge/build-passing-brightgreen.svg)](https://github.com/makalin/phastron)
[![Code Coverage](https://img.shields.io/badge/coverage-90%25-brightgreen.svg)](https://github.com/makalin/phastron)

Phastron is a comprehensive, open-source PHP library that merges **high-performance algorithmic utilities**, **developer-friendly helpers**, and **cutting-edge tooling** into one lightweight package. Designed for modern PHP 8.3+ projects, it offers everything from blazing-fast sort algorithms to memory-safe data structures, with a focus on performance, security, and developer experience.

---

## 🚀 **Quick Start**

### Installation

```bash
composer require phastron/phastron
```

### Basic Usage

```php
use Phastron\Sort\Engine;
use Phastron\Cli\Color;
use Phastron\Struct\BloomFilter;

// Sort with TimSort (Python's default algorithm)
$sorted = Engine::sort([3, 1, 4, 1, 5, 9, 2, 6], Engine::TIM_SORT);

// Beautiful CLI output with gradients
echo Color::gradient("Hello, Phastron!", '#ff007f', '#00c6ff');

// Bloom filter for 10M items, 0.1% false positive rate
$bf = BloomFilter::init(10_000_000, 0.001);
$bf->add('phastron');
var_dump($bf->mightContain('phastron')); // true
```

---

## 🛠️ **Core Features**

### **🎯 Sorting Suite** *(8 Advanced Algorithms)*

| Algorithm | Time Complexity | Stable | In-Place | Best For |
|-----------|----------------|--------|----------|----------|
| **TimSort** | O(n log n) | ✅ | ❌ | General purpose, stable sorting |
| **Pattern-Defeating QuickSort** | O(n log n) avg | ❌ | ✅ | Partially sorted data |
| **Dual-Pivot QuickSort** | O(n log n) | ❌ | ✅ | Java 7+ style performance |
| **GrailSort** | O(n log n) | ✅ | ✅ | In-place stable merge sort |
| **PDQSort-Branchless** | O(n log n) | ❌ | ✅ | Uniform key distributions |
| **BitonicSort** | O(log² n) | ❌ | ✅ | GPU-friendly parallel sort |
| **FlashSort** | O(n) uniform | ❌ | ✅ | Numeric keys, uniform distribution |
| **CycleSort** | O(n²) | ❌ | ✅ | Minimize writes (EEPROM) |

**Usage:**
```php
use Phastron\Sort\Engine;

// Choose your algorithm
$sorted = Engine::sort($array, Engine::TIM_SORT);
$sorted = Engine::sort($array, Engine::PATTERN_DEFEATING_QUICKSORT);
$sorted = Engine::sort($array, Engine::GRAIL_SORT);

// With custom comparator
$sorted = Engine::sort($array, Engine::TIM_SORT, function($a, $b) {
    return strlen($a) <=> strlen($b);
});

// Get available algorithms
$algorithms = Engine::getAvailableAlgorithms();
```

### **🎨 CLI Utilities**

**24-bit True Color Support with Gradients:**
```php
use Phastron\Cli\Color;

// Gradient text (24-bit true color)
echo Color::gradient("Beautiful gradient!", '#ff007f', '#00c6ff');

// Named colors
echo Color::colorize("Red text", 'red');
echo Color::background("Blue background", 'blue');

// Text formatting
echo Color::bold("Bold text");
echo Color::italic("Italic text");
echo Color::underline("Underlined text");

// Custom hex colors
echo Color::gradient("Custom colors", '#ff6b6b', '#4ecdc4');
```

### **🏗️ Data Structures**

**BloomFilter - Probabilistic Set Membership:**
```php
use Phastron\Struct\BloomFilter;

// Initialize with expected items and false positive rate
$bf = BloomFilter::init(1_000_000, 0.01); // 1M items, 1% FP rate

// Add items
$bf->add('user123');
$bf->add('user456');

// Check membership
var_dump($bf->mightContain('user123')); // true
var_dump($bf->mightContain('user789')); // false (probably)

// Save/load from file
$bf->toFile('users.bf');
$loaded = BloomFilter::fromFile('users.bf');

// Get statistics
$stats = $bf->getStats();
echo "False positive rate: " . ($stats['estimated_false_positive_rate'] * 100) . "%";
```

**ImmutableArray - Functional Programming:**
```php
use Phastron\Struct\ImmutableArray;

$arr = ImmutableArray::from([1, 2, 3, 4, 5, 6, 7, 8, 9, 10]);

// Chain operations (all return new instances)
$result = $arr->map(fn($n) => $n * 2)
              ->filter(fn($n) => $n > 10)
              ->take(3)
              ->reverse();

echo implode(', ', $result->toArray()); // "20, 18, 16"

// Utility methods
$arr->range(1, 10, 2);        // [1, 3, 5, 7, 9]
$arr->repeat('x', 5);         // ['x', 'x', 'x', 'x', 'x']
$arr->chunk(3);               // [[1,2,3], [4,5,6], [7,8,9]]
$arr->unique();                // Remove duplicates
$arr->sort();                  // Sort with custom comparator
```

### **🔐 Security Tools**

**SecureToken - Cryptographically Secure:**
```php
use Phastron\Security\SecureToken;

// Various token types
$random = SecureToken::generate(32);           // 32-byte hex
$urlSafe = SecureToken::urlSafe(16);          // URL-safe chars
$numeric = SecureToken::numeric(8);            // 8-digit number
$alphanumeric = SecureToken::alphanumeric(12); // Letters + numbers
$mixed = SecureToken::mixed(20);               // All chars + symbols

// Pattern-based tokens
$pattern = SecureToken::pattern('XXXX-XXXX-XXXX');

// Entropy-based generation
$strong = SecureToken::withEntropy(256);       // 256 bits entropy

// Strength verification
$strength = SecureToken::verifyStrength($token);
echo "Strength score: " . $strength['strength_score'] . "%";
```

### **⏱️ Performance Tools**

**Stopwatch - High-Precision Timing:**
```php
use Phastron\Tools\Stopwatch;

// Basic timing
$stopwatch = Stopwatch::startNew();
// ... your code ...
$stopwatch->stop();
echo "Took: " . $stopwatch->getFormattedTime(); // "1.234 ms"

// Lap timing
$stopwatch->start();
$stopwatch->lap('Database query');
$stopwatch->lap('File processing');
$stopwatch->stop();

$laps = $stopwatch->getLaps();
foreach ($laps as $lap) {
    echo "{$lap['label']}: {$lap['time']}s\n";
}

// Time callables
$result = Stopwatch::time(function() {
    return expensiveOperation();
});
echo "Result: " . $result['result'];
echo "Time: " . $result['timing']['elapsed_time'];
```

### **🔗 String & Text Utilities**

**Slug - URL-Friendly Strings with Transliteration:**
```php
use Phastron\Utility\Slug;

// Basic slug generation
$slug = Slug::create('Hello World!'); // "hello-world"

// Multi-language support
$russian = Slug::create('Привет мир!');     // "privet-mir"
$japanese = Slug::create('こんにちは世界！'); // "konnichiha-shi-jie"
$arabic = Slug::create('مرحبا بالعالم!');   // "mrhaba-blaalm"

// Custom separators and length
$slug = Slug::create('Long text here', '_', 20);

// Custom transliteration rules
$custom = Slug::createCustom('Special text', ['Special' => 'Custom']);
```

**StringHelper - Advanced String Operations:**
```php
use Phastron\Utility\StringHelper;

// Pluralization
echo StringHelper::pluralize('cat', 'cats', 5);        // "cats"
echo StringHelper::autoPluralize('child', 3);          // "children"

// Case conversion
echo StringHelper::toCamelCase('hello world');         // "helloWorld"
echo StringHelper::toSnakeCase('Hello World');         // "hello_world"
echo StringHelper::toKebabCase('Hello World');         // "hello-world"
echo StringHelper::toTitleCase('hello world');         // "Hello World"

// String analysis
echo StringHelper::isPalindrome('racecar');            // true
echo StringHelper::wordCount('Hello world!');          // 2
echo StringHelper::charCount('Hello');                 // 5
echo StringHelper::extractFirstSentence('First. Second.'); // "First"
```

### **✅ Validation Utilities**

**Validator - Comprehensive Input Validation:**
```php
use Phastron\Utility\Validator;

// Network validation
Validator::isValidIP('192.168.1.1');           // true
Validator::isValidIPv4('192.168.1.1');        // true
Validator::isValidIPv6('::1');                // true

// Format validation
Validator::isValidEmail('user@example.com');   // true
Validator::isValidURL('https://github.com');   // true
Validator::isValidJSON('{"key": "value"}');   // true

// String validation
Validator::isAlphanumeric('Hello123');        // true
Validator::isAlphabetic('Hello');             // true
Validator::isNumeric('123');                  // true

// Pattern matching
Validator::matchesPattern('ABC123', '/^[A-Z0-9]+$/'); // true
Validator::isLengthBetween('test', 3, 10);   // true
Validator::startsWith('Hello', 'He');        // true
Validator::endsWith('World', 'ld');          // true
```

---

## 🧪 **Testing & Quality**

### **Running Tests**
```bash
# All tests
composer test

# With coverage report
composer test:coverage

# Code style
composer cs

# Static analysis
composer stan
composer psalm

# All quality checks
composer all
```

### **Using Makefile**
```bash
# Show available commands
make help

# Install dependencies
make install

# Run all checks
make all

# Run example
make example

# Benchmark sorting algorithms
make benchmark

# Clean build artifacts
make clean
```

---

## 🐳 **Docker Support**

```bash
# Build image
docker build -t phastron:latest .

# Run tests in container
docker run --rm phastron:latest composer test

# Interactive shell
docker run --rm -it phastron:latest bash
```

---

## 📊 **Performance Benchmarks**

### **Sorting Algorithm Comparison**

```php
use Phastron\Sort\Engine;
use Phastron\Tools\Stopwatch;

$sizes = [1000, 10000, 100000];
$algorithms = [
    Engine::TIM_SORT,
    Engine::PATTERN_DEFEATING_QUICKSORT,
    Engine::GRAIL_SORT
];

foreach ($sizes as $size) {
    $array = range(1, $size);
    shuffle($array);
    
    foreach ($algorithms as $algo) {
        $stopwatch = Stopwatch::startNew();
        Engine::sort($array, $algo);
        $stopwatch->stop();
        
        echo "Size {$size}, {$algo}: {$stopwatch->getFormattedTime()}\n";
    }
}
```

### **Memory Usage Optimization**

- **BloomFilter**: O(1) lookup with configurable false positive rates
- **ImmutableArray**: Zero-copy operations where possible
- **Sorting**: In-place algorithms minimize memory allocation

---

## 🏗️ **Architecture Highlights**

### **Design Principles**
- **Immutable by Default**: Data structures return new instances
- **Type Safety**: Strict typing with PHP 8.3+ features
- **Performance First**: Optimized algorithms and data structures
- **Developer Experience**: Fluent interfaces and comprehensive documentation

### **Extensibility**
- **Plugin Architecture**: Easy to add new sorting algorithms
- **Interface-Based**: All components implement well-defined contracts
- **Configuration-Driven**: Flexible settings for various use cases

---

## 🚀 **Roadmap**

### **Phase 1** ✅ *(Completed)*
- [x] Core sorting algorithms (8 implementations)
- [x] CLI color system with true-color support
- [x] Data structures (BloomFilter, ImmutableArray)
- [x] Security utilities (SecureToken)
- [x] Performance tools (Stopwatch)
- [x] String utilities (Slug, StringHelper)
- [x] Validation system
- [x] Comprehensive testing framework

### **Phase 2** 🔄 *(In Progress)*
- [ ] SIMD-accelerated radix sort
- [ ] Async HTTP pool helper
- [ ] Advanced memory profiling
- [ ] GPU acceleration support

### **Phase 3** 📋 *(Planned)*
- [ ] `phastron init` CLI scaffolding
- [ ] PHPStan & Psalm stubs
- [ ] Performance regression testing
- [ ] Machine learning utilities

---

## 🤝 **Contributing**

We ❤️ contributions! See [CONTRIBUTING.md](CONTRIBUTING.md) for:

- **Coding Standards**: PSR-12, strict types, comprehensive testing
- **Performance Guidelines**: Benchmarking and optimization strategies
- **Architecture Patterns**: Design principles and best practices
- **Testing Requirements**: Unit tests, integration tests, performance tests

### **Quick Contribution**
```bash
# Fork and clone
git clone https://github.com/makalin/phastron.git
cd phastron

# Install dependencies
composer install

# Run tests
composer test

# Make changes and test
composer all

# Submit PR! 🚀
```

---

## 📄 **License**

MIT © 2025 Phastron Contributors

---

## 🌟 **Show Your Support**

If you find Phastron useful, please:

- ⭐ **Star** this repository
- 🔔 **Watch** for updates
- 🐛 **Report** bugs
- 💡 **Request** features
- 🤝 **Contribute** code

---

> **GitHub Repository**: [github.com/makalin/phastron](https://github.com/makalin/phastron)
> 
> **Documentation**: [Check examples/](examples/) for comprehensive usage examples
> 
> **Community**: Join discussions and share your use cases!

---

*Built with ❤️ for the PHP community*
