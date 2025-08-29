.PHONY: help install test test-coverage cs stan psalm all clean example

help: ## Show this help message
	@echo "Phastron - The Ultimate PHP Utility Arsenal"
	@echo ""
	@echo "Available commands:"
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "  \033[36m%-20s\033[0m %s\n", $$1, $$2}'

install: ## Install dependencies
	composer install

test: ## Run tests
	composer test

test-coverage: ## Run tests with coverage report
	composer test:coverage

cs: ## Fix code style
	composer cs

cs-check: ## Check code style without fixing
	composer cs:check

stan: ## Run PHPStan static analysis
	composer stan

psalm: ## Run Psalm static analysis
	composer psalm

all: ## Run all quality checks (CS, static analysis, tests)
	composer all

clean: ## Clean build artifacts
	rm -rf coverage/
	rm -rf build/
	rm -rf vendor/
	rm -f composer.lock

example: ## Run the basic usage example
	php examples/basic_usage.php

benchmark: ## Run sorting algorithm benchmarks
	@echo "Running sorting benchmarks..."
	@php -r "
	require_once 'vendor/autoload.php';
	use Phastron\Sort\Engine;
	use Phastron\Tools\Stopwatch;
	
	\$sizes = [100, 1000, 10000];
	\$algorithms = [Engine::TIM_SORT, Engine::PATTERN_DEFEATING_QUICKSORT];
	
	foreach (\$sizes as \$size) {
		echo \"Testing with array size: {\$size}\n\";
		\$array = range(1, \$size);
		shuffle(\$array);
		
		foreach (\$algorithms as \$algo) {
			\$stopwatch = Stopwatch::startNew();
			Engine::sort(\$array, \$algo);
			\$stopwatch->stop();
			echo \"  {\$algo}: {\$stopwatch->getFormattedTime()}\n\";
		}
		echo \"\n\";
	}
	"

docker-build: ## Build Docker image for testing
	docker build -t phastron:latest .

docker-test: ## Run tests in Docker
	docker run --rm phastron:latest composer test

docker-bash: ## Run bash in Docker container
	docker run --rm -it phastron:latest bash

update-deps: ## Update dependencies to latest versions
	composer update

security-check: ## Check for security vulnerabilities
	composer audit

format: ## Format all PHP files
	find src tests examples -name "*.php" -exec php-cs-fixer fix {} \;

lint: ## Lint all PHP files
	find src tests examples -name "*.php" -exec php -l {} \;

docs: ## Generate documentation (if available)
	@echo "Documentation generation not yet implemented"
	@echo "Check README.md for current documentation"

release: ## Prepare for release (run all checks)
	@echo "Running all quality checks before release..."
	$(MAKE) all
	@echo "All checks passed! Ready for release."
