<?php

declare(strict_types=1);

namespace Phastron\Tests\Cli;

use Phastron\Cli\Color;
use PHPUnit\Framework\TestCase;

class ColorTest extends TestCase
{
    public function testColorizeWithValidColor(): void
    {
        $result = Color::colorize('test', 'red');
        $this->assertStringContainsString('test', $result);
        $this->assertStringContainsString("\033[", $result);
    }

    public function testColorizeWithInvalidColor(): void
    {
        $result = Color::colorize('test', 'invalid_color');
        $this->assertEquals('test', $result);
    }

    public function testBackgroundWithValidColor(): void
    {
        $result = Color::background('test', 'blue');
        $this->assertStringContainsString('test', $result);
        $this->assertStringContainsString("\033[", $result);
    }

    public function testBold(): void
    {
        $result = Color::bold('test');
        $this->assertStringContainsString('test', $result);
        $this->assertStringContainsString("\033[1m", $result);
    }

    public function testItalic(): void
    {
        $result = Color::italic('test');
        $this->assertStringContainsString('test', $result);
        $this->assertStringContainsString("\033[3m", $result);
    }

    public function testUnderline(): void
    {
        $result = Color::underline('test');
        $this->assertStringContainsString('test', $result);
        $this->assertStringContainsString("\033[4m", $result);
    }

    public function testGradient(): void
    {
        $result = Color::gradient('test', '#ff0000', '#00ff00');
        $this->assertStringContainsString('test', $result);
        // Note: Gradient output depends on terminal support
    }
}
