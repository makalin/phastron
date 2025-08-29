<?php

declare(strict_types=1);

namespace Phastron\Utility;

/**
 * Utility class for common validations.
 */
final class Validator
{
    /**
     * Validate IPv4 address.
     *
     * @param string $ip IP address to validate
     * @return bool True if valid IPv4
     */
    public static function isValidIPv4(string $ip): bool
    {
        return filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4) !== false;
    }

    /**
     * Validate IPv6 address.
     *
     * @param string $ip IP address to validate
     * @return bool True if valid IPv6
     */
    public static function isValidIPv6(string $ip): bool
    {
        return filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6) !== false;
    }

    /**
     * Validate IP address (IPv4 or IPv6).
     *
     * @param string $ip IP address to validate
     * @return bool True if valid IP
     */
    public static function isValidIP(string $ip): bool
    {
        return filter_var($ip, FILTER_VALIDATE_IP) !== false;
    }

    /**
     * Validate email address.
     *
     * @param string $email Email to validate
     * @return bool True if valid email
     */
    public static function isValidEmail(string $email): bool
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }

    /**
     * Validate URL.
     *
     * @param string $url URL to validate
     * @return bool True if valid URL
     */
    public static function isValidURL(string $url): bool
    {
        return filter_var($url, FILTER_VALIDATE_URL) !== false;
    }

    /**
     * Validate if string contains only alphanumeric characters.
     *
     * @param string $string String to validate
     * @return bool True if alphanumeric only
     */
    public static function isAlphanumeric(string $string): bool
    {
        return ctype_alnum($string);
    }

    /**
     * Validate if string contains only alphabetic characters.
     *
     * @param string $string String to validate
     * @return bool True if alphabetic only
     */
    public static function isAlphabetic(string $string): bool
    {
        return ctype_alpha($string);
    }

    /**
     * Validate if string contains only numeric characters.
     *
     * @param string $string String to validate
     * @return bool True if numeric only
     */
    public static function isNumeric(string $string): bool
    {
        return ctype_digit($string);
    }

    /**
     * Validate if string is a valid JSON.
     *
     * @param string $string String to validate
     * @return bool True if valid JSON
     */
    public static function isValidJSON(string $string): bool
    {
        json_decode($string);
        return json_last_error() === JSON_ERROR_NONE;
    }

    /**
     * Validate if string matches a regex pattern.
     *
     * @param string $string String to validate
     * @param string $pattern Regex pattern
     * @return bool True if matches pattern
     */
    public static function matchesPattern(string $string, string $pattern): bool
    {
        return preg_match($pattern, $string) === 1;
    }

    /**
     * Validate if string length is within range.
     *
     * @param string $string String to validate
     * @param int $min Minimum length
     * @param int $max Maximum length
     * @return bool True if length is within range
     */
    public static function isLengthBetween(string $string, int $min, int $max): bool
    {
        $length = mb_strlen($string);
        return $length >= $min && $length <= $max;
    }

    /**
     * Validate if string starts with a specific substring.
     *
     * @param string $string String to validate
     * @param string $prefix Prefix to check
     * @return bool True if string starts with prefix
     */
    public static function startsWith(string $string, string $prefix): bool
    {
        return str_starts_with($string, $prefix);
    }

    /**
     * Validate if string ends with a specific substring.
     *
     * @param string $string String to validate
     * @param string $suffix Suffix to check
     * @return bool True if string ends with suffix
     */
    public static function endsWith(string $string, string $suffix): bool
    {
        return str_ends_with($string, $suffix);
    }

    /**
     * Validate if string contains a specific substring.
     *
     * @param string $string String to validate
     * @param string $substring Substring to check
     * @return bool True if string contains substring
     */
    public static function contains(string $string, string $substring): bool
    {
        return str_contains($string, $substring);
    }
}
