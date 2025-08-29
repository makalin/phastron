# 🚀 **Phastron** – *The Ultimate PHP Utility Arsenal*

Phastron is a brand-new, open-source PHP library that merges **high-performance algorithmic utilities**, **developer-friendly helpers**, and **cutting-edge tooling** into one lightweight package. Designed for modern PHP 8.3+ projects, it offers everything from blazing-fast sort algorithms to memory-safe data structures.

---

## 📦 Installation

```bash
composer require phastron/phastron
```

---

## 🛠️ Features at a Glance

| Category        | Tools & Algorithms                                                                 |
|-----------------|--------------------------------------------------------------------------------------|
| **Sorting**     | 8 optimized algorithms (see below)                                                  |
| **Helpers**     | CLI colors, string pluralizer, IP validator, slug generator                        |
| **DataStruct**  | BloomFilter, RingBuffer, ImmutableArray                                             |
| **Tools**       | Stopwatch, progress bar, memory profiler, file-tail                                 |
| **Security**    | Constant-time string compare, secure random token generator                         |

---

## 🧪 Sorting Suite (new!)

| Algorithm        | Time Complexity | Stable | In-Place | Notes                                 |
|------------------|-----------------|--------|----------|----------------------------------------|
| TimSort          | O(n log n)      | ✅     | ❌       | Hybrid stable sort (Python’s default) |
| Pattern-Defeating QuickSort | O(n log n) avg | ❌ | ✅ | Adapts to partially sorted data |
| Dual-Pivot QuickSort | O(n log n)  | ❌     | ✅       | Used by Java 7+                       |
| GrailSort        | O(n log n)      | ✅     | ✅       | In-place stable merge sort            |
| PDQSort-Branchless | O(n log n)    | ❌     | ✅       | Optimized for uniform keys           |
| BitonicSort      | O(log² n)       | ❌     | ✅       | GPU-friendly parallel sort            |
| FlashSort        | O(n) (uniform)  | ❌     | ✅       | Distribution sort for numeric keys    |
| CycleSort        | O(n²)           | ❌     | ✅       | Minimizes writes, perfect for EEPROM  |

Usage example:

```php
use Phastron\Sort\Engine;

$sorted = Engine::sort($array, Engine::TIM_SORT);
```

---

## 🔧 New Utilities & Options

| Utility                | What’s new?                                                                 |
|------------------------|------------------------------------------------------------------------------|
| `CliColor::gradient()` | 24-bit true-color gradients in terminal output                              |
| `Slug::transliterate()` | Transliterate any UTF-8 script → ASCII slug                                |
| `BloomFilter::fromFile()` | Hydrate a Bloom filter from a serialized file                             |
| `RingBuffer::parallelMap()` | Apply callable in parallel using ext-parallel                          |
| `SecureToken::urlSafe()` | URL-safe, constant-time tokens with configurable entropy                   |

---

## 📋 Quick-start Examples

```php
use Phastron\Cli\Color;
use Phastron\Struct\BloomFilter;

// 1. Colorful CLI
echo Color::gradient("Hello, Phastron!", '#ff007f', '#00c6ff');

// 2. Bloom filter for 10M items, 0.1 % FP rate
$bf = BloomFilter::init(10_000_000, 0.001);
$bf->add('phastron');
var_dump($bf->mightContain('phastron')); // true

// 3. Immutable array with functional API
$arr = \Phastron\Struct\ImmutableArray::from([1,2,3])
        ->map(fn($n) => $n * 2)
        ->filter(fn($n) => $n > 3);
print_r($arr->toArray()); // [4,6]
```

---

## 🧩 Roadmap

- [ ] SIMD-accelerated in-place radix sort
- [ ] Async HTTP pool helper (Guzzle-backed)
- [ ] `phastron init` CLI scaffolding
- [ ] PHPStan & Psalm stubs for zero-config static analysis

---

## 🤝 Contributing

We ❤️ PRs! See [CONTRIBUTING.md](CONTRIBUTING.md) for coding standards and benchmarks.

---

## 📄 License

MIT © 2025 Phastron Contributors

---

> GitHub Repository: [github.com/makalin/phastron](https://github.com/makalin/phastron) – star ⭐️ & watch for real-time updates!
