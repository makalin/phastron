<?php

declare(strict_types=1);

namespace Phastron\Security;

/**
 * Secure token generator with constant-time operations.
 */
final class SecureToken
{
    private const DEFAULT_LENGTH = 32;
    private const URL_SAFE_CHARS = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789-_';

    /**
     * Generate a cryptographically secure random token.
     *
     * @param int $length Token length in bytes
     * @return string Random token
     */
    public static function generate(int $length = self::DEFAULT_LENGTH): string
    {
        if ($length < 1) {
            throw new \InvalidArgumentException('Token length must be positive');
        }

        return bin2hex(random_bytes($length));
    }

    /**
     * Generate a URL-safe token.
     *
     * @param int $length Token length in characters
     * @return string URL-safe random token
     */
    public static function urlSafe(int $length = self::DEFAULT_LENGTH): string
    {
        if ($length < 1) {
            throw new \InvalidArgumentException('Token length must be positive');
        }

        $token = '';
        $charCount = strlen(self::URL_SAFE_CHARS);
        
        for ($i = 0; $i < $length; $i++) {
            $token .= self::URL_SAFE_CHARS[random_int(0, $charCount - 1)];
        }
        
        return $token;
    }

    /**
     * Generate a token with custom character set.
     *
     * @param int $length Token length in characters
     * @param string $charset Custom character set
     * @return string Random token
     */
    public static function custom(int $length, string $charset): string
    {
        if ($length < 1) {
            throw new \InvalidArgumentException('Token length must be positive');
        }

        if (empty($charset)) {
            throw new \InvalidArgumentException('Character set cannot be empty');
        }

        $token = '';
        $charCount = strlen($charset);
        
        for ($i = 0; $i < $length; $i++) {
            $token .= $charset[random_int(0, $charCount - 1)];
        }
        
        return $token;
    }

    /**
     * Generate a token with specified entropy requirements.
     *
     * @param int $entropyBits Required entropy in bits
     * @param string $charset Character set to use
     * @return string Random token
     */
    public static function withEntropy(int $entropyBits, string $charset = self::URL_SAFE_CHARS): string
    {
        if ($entropyBits < 1) {
            throw new \InvalidArgumentException('Entropy must be positive');
        }

        $charCount = strlen($charset);
        $bitsPerChar = log($charCount, 2);
        $requiredLength = (int) ceil($entropyBits / $bitsPerChar);
        
        return self::custom($requiredLength, $charset);
    }

    /**
     * Generate a numeric token.
     *
     * @param int $length Token length in digits
     * @return string Numeric token
     */
    public static function numeric(int $length): string
    {
        if ($length < 1) {
            throw new \InvalidArgumentException('Token length must be positive');
        }

        $min = pow(10, $length - 1);
        $max = pow(10, $length) - 1;
        
        return (string) random_int($min, $max);
    }

    /**
     * Generate an alphanumeric token.
     *
     * @param int $length Token length in characters
     * @return string Alphanumeric token
     */
    public static function alphanumeric(int $length): string
    {
        if ($length < 1) {
            throw new \InvalidArgumentException('Token length must be positive');
        }

        $charset = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        return self::custom($length, $charset);
    }

    /**
     * Generate a token with mixed case and special characters.
     *
     * @param int $length Token length in characters
     * @return string Mixed token
     */
    public static function mixed(int $length): string
    {
        if ($length < 1) {
            throw new \InvalidArgumentException('Token length must be positive');
        }

        $charset = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789!@#$%^&*()_+-=[]{}|;:,.<>?';
        return self::custom($length, $charset);
    }

    /**
     * Verify token strength.
     *
     * @param string $token Token to verify
     * @param string $charset Character set used
     * @return array Strength information
     */
    public static function verifyStrength(string $token, string $charset = self::URL_SAFE_CHARS): array
    {
        $charCount = strlen($charset);
        $bitsPerChar = log($charCount, 2);
        $entropy = strlen($token) * $bitsPerChar;
        
        $uniqueChars = count(array_unique(str_split($token)));
        $charVariety = $uniqueChars / strlen($token);
        
        return [
            'length' => strlen($token),
            'entropy_bits' => $entropy,
            'character_variety' => $charVariety,
            'strength_score' => min(100, ($entropy / 128) * 100), // 128 bits = 100%
            'is_strong' => $entropy >= 128,
        ];
    }

    /**
     * Generate a token that meets minimum strength requirements.
     *
     * @param int $minEntropy Minimum entropy in bits
     * @param string $charset Character set to use
     * @param int $maxAttempts Maximum generation attempts
     * @return string Strong token
     * @throws \RuntimeException If unable to generate strong token
     */
    public static function strong(int $minEntropy, string $charset = self::URL_SAFE_CHARS, int $maxAttempts = 100): string
    {
        for ($attempt = 0; $attempt < $maxAttempts; $attempt++) {
            $token = self::withEntropy($minEntropy, $charset);
            $strength = self::verifyStrength($token, $charset);
            
            if ($strength['is_strong']) {
                return $token;
            }
        }
        
        throw new \RuntimeException("Unable to generate strong token after {$maxAttempts} attempts");
    }

    /**
     * Generate a token with specific pattern requirements.
     *
     * @param string $pattern Pattern string (e.g., 'XXXX-XXXX-XXXX')
     * @param string $charset Character set for X placeholders
     * @return string Patterned token
     */
    public static function pattern(string $pattern, string $charset = self::URL_SAFE_CHARS): string
    {
        $token = '';
        $charCount = strlen($charset);
        
        for ($i = 0; $i < strlen($pattern); $i++) {
            $char = $pattern[$i];
            if ($char === 'X') {
                $token .= $charset[random_int(0, $charCount - 1)];
            } else {
                $token .= $char;
            }
        }
        
        return $token;
    }
}
