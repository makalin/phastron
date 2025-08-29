<?php

declare(strict_types=1);

namespace Phastron\Tests\Sort;

use Phastron\Sort\Engine;
use PHPUnit\Framework\TestCase;

class EngineTest extends TestCase
{
    public function testSortWithTimSort(): void
    {
        $array = [3, 1, 4, 1, 5, 9, 2, 6];
        $sorted = Engine::sort($array, Engine::TIM_SORT);
        
        $this->assertEquals([1, 1, 2, 3, 4, 5, 6, 9], $sorted);
    }

    public function testSortWithCustomComparator(): void
    {
        $array = ['banana', 'apple', 'cherry'];
        $sorted = Engine::sort($array, Engine::TIM_SORT, function($a, $b) {
            return strlen($a) <=> strlen($b);
        });
        
        $this->assertEquals(['apple', 'banana', 'cherry'], $sorted);
    }

    public function testGetAvailableAlgorithms(): void
    {
        $algorithms = Engine::getAvailableAlgorithms();
        
        $this->assertContains(Engine::TIM_SORT, $algorithms);
        $this->assertContains(Engine::PATTERN_DEFEATING_QUICKSORT, $algorithms);
        $this->assertContains(Engine::DUAL_PIVOT_QUICKSORT, $algorithms);
    }

    public function testIsAlgorithmSupported(): void
    {
        $this->assertTrue(Engine::isAlgorithmSupported(Engine::TIM_SORT));
        $this->assertFalse(Engine::isAlgorithmSupported('invalid_algorithm'));
    }

    public function testSortWithInvalidAlgorithm(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Unsupported sorting algorithm: invalid_algorithm');
        
        Engine::sort([1, 2, 3], 'invalid_algorithm');
    }
}
