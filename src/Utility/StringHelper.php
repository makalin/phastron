<?php

declare(strict_types=1);

namespace Phastron\Utility;

/**
 * Utility class for string operations.
 */
final class StringHelper
{
    /**
     * Pluralize a word based on count.
     *
     * @param string $singular Singular form
     * @param string $plural Plural form
     * @param int $count Count to determine form
     * @return string Appropriate form
     */
    public static function pluralize(string $singular, string $plural, int $count): string
    {
        return $count === 1 ? $singular : $plural;
    }

    /**
     * Pluralize a word with automatic plural detection.
     *
     * @param string $word Word to pluralize
     * @param int $count Count to determine form
     * @return string Pluralized word
     */
    public static function autoPluralize(string $word, int $count): string
    {
        if ($count === 1) {
            return $word;
        }

        $rules = [
            '/(quiz)$/i' => '$1zes',
            '/(matr|vert|ind)ix|ex$/i' => '$1ices',
            '/(x|ch|ss|sh)$/i' => '$1es',
            '/([^aeiouy]|qu)y$/i' => '$1ies',
            '/(hive)$/i' => '$1s',
            '/(?:([^f])fe|([lr])f)$/i' => '$1$2ves',
            '/(shea|lea|loa|thie)f$/i' => '$1ves',
            '/sis$/i' => 'ses',
            '/([ti])um$/i' => '$1a',
            '/(tomat|potat|ech|her|vet)o$/i' => '$1oes',
            '/(bu)s$/i' => '$1ses',
            '/(alias)$/i' => '$1es',
            '/(octop)us$/i' => '$1i',
            '/(ax|test)is$/i' => '$1es',
            '/(us)$/i' => '$1es',
            '/s$/i' => 's',
            '/$/' => 's',
        ];

        foreach ($rules as $rule => $replacement) {
            if (preg_match($rule, $word)) {
                return preg_replace($rule, $replacement, $word);
            }
        }

        return $word . 's';
    }

    /**
     * Convert string to title case.
     *
     * @param string $string String to convert
     * @return string Title case string
     */
    public static function toTitleCase(string $string): string
    {
        return ucwords(strtolower($string));
    }

    /**
     * Convert string to camel case.
     *
     * @param string $string String to convert
     * @return string Camel case string
     */
    public static function toCamelCase(string $string): string
    {
        $string = preg_replace('/[^a-zA-Z0-9\x80-\xff]+/', ' ', $string);
        $string = trim($string);
        $string = ucwords($string);
        $string = str_replace(' ', '', $string);
        return lcfirst($string);
    }

    /**
     * Convert string to snake case.
     *
     * @param string $string String to convert
     * @return string Snake case string
     */
    public static function toSnakeCase(string $string): string
    {
        $string = preg_replace('/[^a-zA-Z0-9\x80-\xff]+/', ' ', $string);
        $string = trim($string);
        $string = preg_replace('/\s+/', '_', $string);
        return strtolower($string);
    }

    /**
     * Convert string to kebab case.
     *
     * @param string $string String to convert
     * @return string Kebab case string
     */
    public static function toKebabCase(string $string): string
    {
        $string = preg_replace('/[^a-zA-Z0-9\x80-\xff]+/', ' ', $string);
        $string = trim($string);
        $string = preg_replace('/\s+/', '-', $string);
        return strtolower($string);
    }

    /**
     * Truncate string to specified length.
     *
     * @param string $string String to truncate
     * @param int $length Maximum length
     * @param string $suffix Suffix to append
     * @return string Truncated string
     */
    public static function truncate(string $string, int $length, string $suffix = '...'): string
    {
        if (mb_strlen($string) <= $length) {
            return $string;
        }

        return rtrim(mb_substr($string, 0, $length - mb_strlen($suffix))) . $suffix;
    }

    /**
     * Generate a random string.
     *
     * @param int $length Length of string
     * @param string $charset Character set to use
     * @return string Random string
     */
    public static function random(int $length, string $charset = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789'): string
    {
        $result = '';
        $charCount = strlen($charset);
        
        for ($i = 0; $i < $length; $i++) {
            $result .= $charset[random_int(0, $charCount - 1)];
        }
        
        return $result;
    }

    /**
     * Reverse a string.
     *
     * @param string $string String to reverse
     * @return string Reversed string
     */
    public static function reverse(string $string): string
    {
        return strrev($string);
    }

    /**
     * Count words in a string.
     *
     * @param string $string String to count words in
     * @return int Word count
     */
    public static function wordCount(string $string): int
    {
        return str_word_count($string);
    }

    /**
     * Count characters in a string.
     *
     * @param string $string String to count characters in
     * @return int Character count
     */
    public static function charCount(string $string): int
    {
        return mb_strlen($string);
    }

    /**
     * Check if string is palindrome.
     *
     * @param string $string String to check
     * @return bool True if palindrome
     */
    public static function isPalindrome(string $string): bool
    {
        $clean = preg_replace('/[^a-zA-Z0-9]/', '', strtolower($string));
        return $clean === strrev($clean);
    }

    /**
     * Extract first sentence from text.
     *
     * @param string $text Text to extract from
     * @return string First sentence
     */
    public static function extractFirstSentence(string $text): string
    {
        $sentences = preg_split('/[.!?]+/', $text, 2);
        return trim($sentences[0]);
    }

    /**
     * Count sentences in text.
     *
     * @param string $text Text to count sentences in
     * @return int Sentence count
     */
    public static function sentenceCount(string $text): int
    {
        $sentences = preg_split('/[.!?]+/', $text);
        return count(array_filter($sentences, 'trim'));
    }
}
