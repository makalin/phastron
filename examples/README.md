# 🚀 Phastron Examples

This directory contains comprehensive examples demonstrating all the features of Phastron. Each example file focuses on specific functionality and provides practical, real-world usage patterns.

## 📁 Available Examples

### **1. `basic_usage.php`** - Complete Feature Overview
**Purpose**: Comprehensive demonstration of all Phastron features
**Features Covered**:
- Sorting algorithms with performance timing
- CLI colors and gradients
- Bloom filter operations
- Immutable array functional programming
- Slug generation with multi-language support
- Secure token generation
- Validation utilities
- String manipulation
- Performance benchmarking
- Real-world use cases

**Run with**: `php examples/basic_usage.php`

---

### **2. `sorting_benchmarks.php`** - Algorithm Performance Analysis
**Purpose**: Detailed performance comparison of all sorting algorithms
**Features Covered**:
- 8 sorting algorithm performance tests
- Multiple data scenarios (random, nearly sorted, reverse sorted, duplicates)
- Memory usage analysis
- Stability testing
- Algorithm characteristics summary
- Performance optimization insights

**Run with**: `php examples/sorting_benchmarks.php`

---

### **3. `cli_utilities.php`** - Terminal Color & Formatting
**Purpose**: Showcase CLI utilities and color system
**Features Covered**:
- 24-bit true-color support
- Gradient text generation
- Background colors and text formatting
- Progress indicators
- Table-like output
- Code highlighting
- ASCII art with colors
- Performance testing

**Run with**: `php examples/cli_utilities.php`

---

### **4. `data_structures.php`** - Data Structure Demonstrations
**Purpose**: Comprehensive data structure examples
**Features Covered**:
- Bloom filter creation and operations
- Large-scale performance testing
- Persistence and file operations
- Immutable array functional operations
- Performance comparisons
- Memory usage analysis
- Real-world use cases
- Error handling and edge cases

**Run with**: `php examples/data_structures.php`

---

### **5. `security_utilities.php`** - Security & Validation Tools
**Purpose**: Security utilities and input validation
**Features Covered**:
- Secure token generation (multiple types)
- Token strength analysis
- Comprehensive validation (IP, email, URL, JSON)
- String validation and pattern matching
- String utilities and case conversion
- Slug generation with transliteration
- Performance testing
- Real-world security scenarios

**Run with**: `php examples/security_utilities.php`

---

### **6. `performance_tools.php`** - Performance Measurement
**Purpose**: Performance tools and benchmarking
**Features Covered**:
- Basic stopwatch operations
- Lap timing and continuous monitoring
- Performance comparisons
- Function timing utilities
- Memory usage monitoring
- Benchmarking framework
- Real-world performance testing
- Optimization examples

**Run with**: `php examples/performance_tools.php`

---

## 🚀 Quick Start

### **Run All Examples**
```bash
# Install dependencies first
composer install

# Run the main example
php examples/basic_usage.php

# Run specific examples
php examples/sorting_benchmarks.php
php examples/cli_utilities.php
php examples/data_structures.php
php examples/security_utilities.php
php examples/performance_tools.php
```

### **Using Makefile**
```bash
# Run the main example
make example

# Run all examples (if you want to create a script for this)
make examples
```

## 🎯 **Example Categories**

### **🔧 Core Features**
- **Sorting**: 8 advanced algorithms with performance analysis
- **Data Structures**: BloomFilter, ImmutableArray with functional programming
- **CLI Tools**: 24-bit true-color support with gradients
- **Security**: Cryptographically secure token generation
- **Performance**: High-precision timing and benchmarking

### **🛠️ Utilities**
- **Validation**: IP, email, URL, JSON, and custom pattern validation
- **String Operations**: Case conversion, analysis, pluralization
- **Slug Generation**: Multi-language support with transliteration
- **Performance Tools**: Stopwatch, lap timing, memory monitoring

### **🌍 Real-world Applications**
- **User Management**: Bloom filter for user lookup
- **Content Management**: Article slug generation
- **Data Processing**: Functional programming pipelines
- **API Security**: Token generation for different purposes
- **Performance Optimization**: Algorithm selection and optimization

## 📊 **Performance Insights**

### **Sorting Algorithms**
- **TimSort**: Best for general-purpose, stable sorting
- **Pattern-Defeating QuickSort**: Best for partially sorted data
- **GrailSort**: Best for memory-constrained environments
- **FlashSort**: Best for numeric keys with uniform distribution

### **Data Structures**
- **BloomFilter**: O(1) lookup with configurable false positive rates
- **ImmutableArray**: Zero-copy operations where possible
- **Memory Optimization**: Efficient algorithms minimize allocation

### **CLI Performance**
- **True-color Support**: Automatic fallback for older terminals
- **Gradient Generation**: Optimized for performance
- **Memory Efficient**: Minimal memory overhead

## 🔍 **Learning Path**

### **Beginner** → Start Here
1. `basic_usage.php` - Get familiar with all features
2. `cli_utilities.php` - Learn CLI color system
3. `data_structures.php` - Understand data structures

### **Intermediate** → Deep Dive
1. `sorting_benchmarks.php` - Algorithm performance analysis
2. `security_utilities.php` - Security and validation
3. `performance_tools.php` - Performance measurement

### **Advanced** → Customization
- Modify examples to test your own data
- Combine features for complex use cases
- Create custom validation rules
- Implement performance monitoring

## 🐛 **Troubleshooting**

### **Common Issues**
- **Memory Limits**: Some examples use large datasets; increase `memory_limit` if needed
- **Execution Time**: Sorting benchmarks may take time with large arrays
- **Terminal Support**: CLI colors work best in modern terminals with true-color support

### **Performance Tips**
- Run benchmarks multiple times for accurate results
- Use appropriate array sizes for your system
- Monitor memory usage during large operations
- Consider algorithm characteristics for your use case

## 📚 **Next Steps**

After running the examples:

1. **Read the Documentation**: Check the main README.md for comprehensive information
2. **Explore the Source**: Examine the source code to understand implementations
3. **Run Tests**: Execute `composer test` to verify functionality
4. **Contribute**: Add your own examples or improve existing ones
5. **Benchmark**: Use the performance tools to test your own code

## 🤝 **Contributing Examples**

We welcome new examples! When contributing:

- Focus on specific functionality or use cases
- Include comprehensive comments and explanations
- Demonstrate real-world scenarios
- Include performance considerations
- Follow the existing code style and structure

---

**Happy coding with Phastron! 🚀**

For questions or contributions, see the main [CONTRIBUTING.md](../CONTRIBUTING.md) file.
