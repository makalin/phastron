<?php

declare(strict_types=1);

namespace Phastron\Struct;

/**
 * BloomFilter implementation for probabilistic set membership testing.
 */
final class BloomFilter
{
    private array $bitArray;
    private int $size;
    private int $hashCount;
    private array $hashFunctions;

    /**
     * Initialize a new Bloom filter.
     *
     * @param int $expectedItems Expected number of items
     * @param float $falsePositiveRate Desired false positive rate
     */
    private function __construct(int $expectedItems, float $falsePositiveRate)
    {
        $this->size = $this->calculateOptimalSize($expectedItems, $falsePositiveRate);
        $this->hashCount = $this->calculateOptimalHashCount($expectedItems, $this->size);
        $this->bitArray = array_fill(0, $this->size, false);
        $this->hashFunctions = $this->generateHashFunctions();
    }

    /**
     * Create a new Bloom filter.
     *
     * @param int $expectedItems Expected number of items
     * @param float $falsePositiveRate Desired false positive rate
     * @return self
     */
    public static function init(int $expectedItems, float $falsePositiveRate): self
    {
        return new self($expectedItems, $falsePositiveRate);
    }

    /**
     * Create a Bloom filter from a serialized file.
     *
     * @param string $filename Path to the serialized file
     * @return self
     * @throws \RuntimeException If file cannot be read
     */
    public static function fromFile(string $filename): self
    {
        if (!file_exists($filename)) {
            throw new \RuntimeException("Bloom filter file not found: {$filename}");
        }

        $data = unserialize(file_get_contents($filename));
        if (!$data instanceof self) {
            throw new \RuntimeException("Invalid bloom filter file format");
        }

        return $data;
    }

    /**
     * Add an item to the filter.
     *
     * @param string $item Item to add
     */
    public function add(string $item): void
    {
        foreach ($this->getHashes($item) as $hash) {
            $this->bitArray[$hash] = true;
        }
    }

    /**
     * Check if an item might be in the filter.
     *
     * @param string $item Item to check
     * @return bool True if item might be present
     */
    public function mightContain(string $item): bool
    {
        foreach ($this->getHashes($item) as $hash) {
            if (!$this->bitArray[$hash]) {
                return false;
            }
        }
        return true;
    }

    /**
     * Save the filter to a file.
     *
     * @param string $filename Path to save the file
     * @return bool True if successful
     */
    public function toFile(string $filename): bool
    {
        return file_put_contents($filename, serialize($this)) !== false;
    }

    /**
     * Get the current false positive rate estimate.
     *
     * @return float Estimated false positive rate
     */
    public function getFalsePositiveRate(): float
    {
        $filledBits = array_sum($this->bitArray);
        $fillRatio = $filledBits / $this->size;
        return pow($fillRatio, $this->hashCount);
    }

    /**
     * Get filter statistics.
     *
     * @return array Filter statistics
     */
    public function getStats(): array
    {
        $filledBits = array_sum($this->bitArray);
        return [
            'size' => $this->size,
            'hash_count' => $this->hashCount,
            'filled_bits' => $filledBits,
            'fill_ratio' => $filledBits / $this->size,
            'estimated_false_positive_rate' => $this->getFalsePositiveRate(),
        ];
    }

    /**
     * Calculate optimal bit array size.
     *
     * @param int $expectedItems Expected number of items
     * @param float $falsePositiveRate Desired false positive rate
     * @return int Optimal size in bits
     */
    private function calculateOptimalSize(int $expectedItems, float $falsePositiveRate): int
    {
        return (int) ceil(-$expectedItems * log($falsePositiveRate) / (log(2) ** 2));
    }

    /**
     * Calculate optimal number of hash functions.
     *
     * @param int $expectedItems Expected number of items
     * @param int $size Bit array size
     * @return int Optimal number of hash functions
     */
    private function calculateOptimalHashCount(int $expectedItems, int $size): int
    {
        return (int) ceil(($size / $expectedItems) * log(2));
    }

    /**
     * Generate hash functions.
     *
     * @return array Array of hash function callables
     */
    private function generateHashFunctions(): array
    {
        $functions = [];
        for ($i = 0; $i < $this->hashCount; $i++) {
            $seed = $i * 2654435761; // FNV prime
            $functions[] = function (string $item) use ($seed): int {
                $hash = $seed;
                $len = strlen($item);
                for ($j = 0; $j < $len; $j++) {
                    $hash = (($hash << 5) + $hash + ord($item[$j])) & 0xFFFFFFFF;
                }
                return $hash % $this->size;
            };
        }
        return $functions;
    }

    /**
     * Get hash values for an item.
     *
     * @param string $item Item to hash
     * @return array Array of hash values
     */
    private function getHashes(string $item): array
    {
        $hashes = [];
        foreach ($this->hashFunctions as $hashFunc) {
            $hashes[] = $hashFunc($item);
        }
        return $hashes;
    }
}
