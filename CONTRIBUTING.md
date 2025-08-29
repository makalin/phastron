# Contributing to Phastron

Thank you for your interest in contributing to Phastron! This document provides guidelines and information for contributors.

## 🚀 Getting Started

### Prerequisites

- PHP 8.3 or higher
- Composer
- Git

### Setup

1. Fork the repository
2. Clone your fork: `git clone https://github.com/YOUR_USERNAME/phastron.git`
3. Install dependencies: `composer install`
4. Create a feature branch: `git checkout -b feature/your-feature-name`

## 📝 Coding Standards

### PHP Standards

- Follow PSR-12 coding standards
- Use strict types (`declare(strict_types=1);`)
- Use proper PHPDoc annotations
- Prefer final classes when possible
- Use meaningful variable and method names

### Code Style

We use PHP CS Fixer to maintain consistent code style. Run:

```bash
composer cs          # Fix code style
composer cs:check    # Check code style without fixing
```

## 🧪 Testing

### Running Tests

```bash
composer test                    # Run all tests
composer test:coverage          # Run tests with coverage report
```

### Writing Tests

- Write tests for all new functionality
- Follow PSR-4 autoloading for test files
- Use descriptive test method names
- Test both positive and negative cases
- Aim for high test coverage

### Test Structure

```php
<?php

declare(strict_types=1);

namespace Phastron\Tests\YourNamespace;

use Phastron\YourNamespace\YourClass;
use PHPUnit\Framework\TestCase;

class YourClassTest extends TestCase
{
    public function testYourMethod(): void
    {
        // Test implementation
    }
}
```

## 🔍 Code Quality

### Static Analysis

We use PHPStan and Psalm for static analysis:

```bash
composer stan       # Run PHPStan
composer psalm      # Run Psalm
```

### Running All Checks

```bash
composer all        # Run CS fixer, static analysis, and tests
```

## 📊 Performance

### Benchmarking

When implementing sorting algorithms or performance-critical code:

1. Include benchmarks comparing with existing solutions
2. Test with various input sizes and data distributions
3. Document time and space complexity
4. Consider edge cases and worst-case scenarios

### Example Benchmark

```php
use Phastron\Tools\Stopwatch;

$stopwatch = Stopwatch::startNew();
$result = $algorithm->sort($largeArray);
$stopwatch->stop();

echo "Sorting took: " . $stopwatch->getFormattedTime();
```

## 🚀 Pull Request Process

### Before Submitting

1. Ensure all tests pass
2. Run code quality checks
3. Update documentation if needed
4. Add appropriate tests for new functionality

### PR Description

Include:

- Description of changes
- Related issue number (if applicable)
- Testing performed
- Performance impact (if any)
- Breaking changes (if any)

### Review Process

1. Automated checks must pass
2. At least one maintainer must approve
3. All feedback must be addressed
4. Maintainers may request changes

## 🏗️ Architecture Guidelines

### Sorting Algorithms

- Implement `SortInterface`
- Document time complexity, stability, and in-place properties
- Include comprehensive tests with various data types
- Consider memory usage and cache performance

### Data Structures

- Use immutable objects when possible
- Implement proper serialization if needed
- Consider thread safety for concurrent usage
- Document performance characteristics

### Utilities

- Keep utilities focused and single-purpose
- Use static methods for stateless operations
- Provide fluent interfaces when appropriate
- Include input validation and error handling

## 📚 Documentation

### Code Documentation

- Use clear, concise PHPDoc comments
- Include usage examples for complex methods
- Document exceptions and error conditions
- Keep examples up-to-date with code changes

### README Updates

- Update feature lists and examples
- Add new utility documentation
- Include performance benchmarks
- Update installation instructions

## 🐛 Bug Reports

### Before Reporting

1. Check existing issues
2. Verify the issue with latest version
3. Test with minimal reproduction case

### Bug Report Template

```markdown
**Description**
Brief description of the issue

**Steps to Reproduce**
1. Step 1
2. Step 2
3. Step 3

**Expected Behavior**
What should happen

**Actual Behavior**
What actually happens

**Environment**
- PHP version
- OS
- Phastron version

**Additional Context**
Any other relevant information
```

## 💡 Feature Requests

### Before Requesting

1. Check if feature already exists
2. Consider if it fits the project scope
3. Think about implementation complexity

### Feature Request Template

```markdown
**Problem**
Description of the problem this feature would solve

**Proposed Solution**
Description of the proposed solution

**Alternatives Considered**
Other solutions you've considered

**Additional Context**
Any other relevant information
```

## 🤝 Community

### Communication

- Be respectful and inclusive
- Use clear, constructive language
- Help other contributors when possible
- Follow the project's code of conduct

### Getting Help

- Check existing documentation
- Search existing issues
- Ask questions in discussions
- Join community channels

## 📄 License

By contributing to Phastron, you agree that your contributions will be licensed under the MIT License.

## 🙏 Recognition

Contributors will be recognized in:

- README.md contributors section
- Release notes
- Project documentation

Thank you for contributing to Phastron! 🚀
