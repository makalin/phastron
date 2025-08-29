<?php

declare(strict_types=1);

namespace Phastron\Cli;

/**
 * CLI color utility with support for 24-bit true-color gradients.
 */
final class Color
{
    // ANSI color codes
    private const COLORS = [
        'black' => 0,
        'red' => 1,
        'green' => 2,
        'yellow' => 3,
        'blue' => 4,
        'magenta' => 5,
        'cyan' => 6,
        'white' => 7,
        'bright_black' => 8,
        'bright_red' => 9,
        'bright_green' => 10,
        'bright_yellow' => 11,
        'bright_blue' => 12,
        'bright_magenta' => 13,
        'bright_cyan' => 14,
        'bright_white' => 15,
    ];

    /**
     * Create a gradient text effect between two colors.
     *
     * @param string $text The text to colorize
     * @param string $startColor Start color (hex or name)
     * @param string $endColor End color (hex or name)
     * @return string Colored text
     */
    public static function gradient(string $text, string $startColor, string $endColor): string
    {
        if (!self::supportsTrueColor()) {
            return $text; // Fallback for terminals without true color support
        }

        $startRgb = self::parseColor($startColor);
        $endRgb = self::parseColor($endColor);
        
        $length = mb_strlen($text);
        $result = '';
        
        for ($i = 0; $i < $length; $i++) {
            $ratio = $i / max(1, $length - 1);
            $r = (int) ($startRgb[0] + ($endRgb[0] - $startRgb[0]) * $ratio);
            $g = (int) ($startRgb[1] + ($endRgb[1] - $startRgb[1]) * $ratio);
            $b = (int) ($startRgb[2] + ($endRgb[2] - $startRgb[2]) * $ratio);
            
            $char = mb_substr($text, $i, 1);
            $result .= "\033[38;2;{$r};{$g};{$b}m{$char}";
        }
        
        return $result . "\033[0m";
    }

    /**
     * Colorize text with a named color.
     *
     * @param string $text The text to colorize
     * @param string $color Color name
     * @return string Colored text
     */
    public static function colorize(string $text, string $color): string
    {
        if (!isset(self::COLORS[$color])) {
            return $text;
        }
        
        $code = self::COLORS[$color];
        return "\033[38;5;{$code}m{$text}\033[0m";
    }

    /**
     * Colorize text with background color.
     *
     * @param string $text The text to colorize
     * @param string $color Background color name
     * @return string Colored text
     */
    public static function background(string $text, string $color): string
    {
        if (!isset(self::COLORS[$color])) {
            return $text;
        }
        
        $code = self::COLORS[$color];
        return "\033[48;5;{$code}m{$text}\033[0m";
    }

    /**
     * Make text bold.
     *
     * @param string $text The text to make bold
     * @return string Bold text
     */
    public static function bold(string $text): string
    {
        return "\033[1m{$text}\033[0m";
    }

    /**
     * Make text italic.
     *
     * @param string $text The text to make italic
     * @return string Italic text
     */
    public static function italic(string $text): string
    {
        return "\033[3m{$text}\033[0m";
    }

    /**
     * Underline text.
     *
     * @param string $text The text to underline
     * @return string Underlined text
     */
    public static function underline(string $text): string
    {
        return "\033[4m{$text}\033[0m";
    }

    /**
     * Check if terminal supports true color.
     *
     * @return bool True if supported
     */
    private static function supportsTrueColor(): bool
    {
        $term = getenv('TERM');
        $colorterm = getenv('COLORTERM');
        
        return $colorterm === 'truecolor' || 
               $colorterm === '24bit' || 
               str_contains($term ?? '', '256color') ||
               str_contains($term ?? '', 'xterm');
    }

    /**
     * Parse color string to RGB values.
     *
     * @param string $color Color string (hex or name)
     * @return array RGB values [r, g, b]
     */
    private static function parseColor(string $color): array
    {
        // Handle hex colors
        if (str_starts_with($color, '#')) {
            $hex = substr($color, 1);
            if (strlen($hex) === 3) {
                $hex = $hex[0] . $hex[0] . $hex[1] . $hex[1] . $hex[2] . $hex[2];
            }
            if (strlen($hex) === 6) {
                return [
                    hexdec(substr($hex, 0, 2)),
                    hexdec(substr($hex, 2, 2)),
                    hexdec(substr($hex, 4, 2)),
                ];
            }
        }
        
        // Handle named colors
        if (isset(self::COLORS[$color])) {
            $code = self::COLORS[$color];
            // Convert 8-bit color to RGB (approximate)
            $r = ($code >> 0) & 0x7;
            $g = ($code >> 3) & 0x7;
            $b = ($code >> 6) & 0x3;
            
            return [
                $r * 36,
                $g * 36,
                $b * 85,
            ];
        }
        
        // Default to white
        return [255, 255, 255];
    }
}
