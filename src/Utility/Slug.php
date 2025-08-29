<?php

declare(strict_types=1);

namespace Phastron\Utility;

/**
 * Slug utility for creating URL-friendly strings with transliteration support.
 */
final class Slug
{
    private const TRANSLITERATION_MAP = [
        // Latin extended
        'À' => 'A', 'Á' => 'A', 'Â' => 'A', 'Ã' => 'A', 'Ä' => 'A', 'Å' => 'A',
        'à' => 'a', 'á' => 'a', 'â' => 'a', 'ã' => 'a', 'ä' => 'a', 'å' => 'a',
        'È' => 'E', 'É' => 'E', 'Ê' => 'E', 'Ë' => 'E',
        'è' => 'e', 'é' => 'e', 'ê' => 'e', 'ë' => 'e',
        'Ì' => 'I', 'Í' => 'I', 'Î' => 'I', 'Ï' => 'I',
        'ì' => 'i', 'í' => 'i', 'î' => 'i', 'ï' => 'i',
        'Ò' => 'O', 'Ó' => 'O', 'Ô' => 'O', 'Õ' => 'O', 'Ö' => 'O',
        'ò' => 'o', 'ó' => 'o', 'ô' => 'o', 'õ' => 'o', 'ö' => 'o',
        'Ù' => 'U', 'Ú' => 'U', 'Û' => 'U', 'Ü' => 'U',
        'ù' => 'u', 'ú' => 'u', 'û' => 'u', 'ü' => 'u',
        'Ý' => 'Y', 'ý' => 'y',
        'Ñ' => 'N', 'ñ' => 'n',
        'Ç' => 'C', 'ç' => 'c',
        
        // Cyrillic
        'А' => 'A', 'Б' => 'B', 'В' => 'V', 'Г' => 'G', 'Д' => 'D', 'Е' => 'E',
        'Ё' => 'E', 'Ж' => 'Zh', 'З' => 'Z', 'И' => 'I', 'Й' => 'Y', 'К' => 'K',
        'Л' => 'L', 'М' => 'M', 'Н' => 'N', 'О' => 'O', 'П' => 'P', 'Р' => 'R',
        'С' => 'S', 'Т' => 'T', 'У' => 'U', 'Ф' => 'F', 'Х' => 'Kh', 'Ц' => 'Ts',
        'Ч' => 'Ch', 'Ш' => 'Sh', 'Щ' => 'Shch', 'Ъ' => '', 'Ы' => 'Y', 'Ь' => '',
        'Э' => 'E', 'Ю' => 'Yu', 'Я' => 'Ya',
        
        'а' => 'a', 'б' => 'b', 'в' => 'v', 'г' => 'g', 'д' => 'd', 'е' => 'e',
        'ё' => 'e', 'ж' => 'zh', 'з' => 'z', 'и' => 'i', 'й' => 'y', 'к' => 'k',
        'л' => 'l', 'м' => 'm', 'н' => 'n', 'о' => 'o', 'п' => 'p', 'р' => 'r',
        'с' => 's', 'т' => 't', 'у' => 'u', 'ф' => 'f', 'х' => 'kh', 'ц' => 'ts',
        'ч' => 'ch', 'ш' => 'sh', 'щ' => 'shch', 'ъ' => '', 'ы' => 'y', 'ь' => '',
        'э' => 'e', 'ю' => 'yu', 'я' => 'ya',
        
        // Greek
        'Α' => 'A', 'Β' => 'B', 'Γ' => 'G', 'Δ' => 'D', 'Ε' => 'E', 'Ζ' => 'Z',
        'Η' => 'H', 'Θ' => 'Th', 'Ι' => 'I', 'Κ' => 'K', 'Λ' => 'L', 'Μ' => 'M',
        'Ν' => 'N', 'Ξ' => 'X', 'Ο' => 'O', 'Π' => 'P', 'Ρ' => 'R', 'Σ' => 'S',
        'Τ' => 'T', 'Υ' => 'Y', 'Φ' => 'Ph', 'Χ' => 'Ch', 'Ψ' => 'Ps', 'Ω' => 'O',
        
        'α' => 'a', 'β' => 'b', 'γ' => 'g', 'δ' => 'd', 'ε' => 'e', 'ζ' => 'z',
        'η' => 'h', 'θ' => 'th', 'ι' => 'i', 'κ' => 'k', 'λ' => 'l', 'μ' => 'm',
        'ν' => 'n', 'ξ' => 'x', 'ο' => 'o', 'π' => 'p', 'ρ' => 'r', 'σ' => 's',
        'τ' => 't', 'υ' => 'u', 'φ' => 'ph', 'χ' => 'ch', 'ψ' => 'ps', 'ω' => 'o',
        
        // Arabic
        'ا' => 'a', 'ب' => 'b', 'ت' => 't', 'ث' => 'th', 'ج' => 'j', 'ح' => 'h',
        'خ' => 'kh', 'د' => 'd', 'ذ' => 'dh', 'ر' => 'r', 'ز' => 'z', 'س' => 's',
        'ش' => 'sh', 'ص' => 's', 'ض' => 'd', 'ط' => 't', 'ظ' => 'z', 'ع' => 'a',
        'غ' => 'gh', 'ف' => 'f', 'ق' => 'q', 'ك' => 'k', 'ل' => 'l', 'م' => 'm',
        'ن' => 'n', 'ه' => 'h', 'و' => 'w', 'ي' => 'y',
        
        // Hebrew
        'א' => 'a', 'ב' => 'b', 'ג' => 'g', 'ד' => 'd', 'ה' => 'h', 'ו' => 'v',
        'ז' => 'z', 'ח' => 'h', 'ט' => 't', 'י' => 'y', 'כ' => 'k', 'ל' => 'l',
        'מ' => 'm', 'נ' => 'n', 'ס' => 's', 'ע' => 'a', 'פ' => 'p', 'צ' => 'ts',
        'ק' => 'q', 'ר' => 'r', 'ש' => 'sh', 'ת' => 't',
        
        // Chinese (simplified)
        '一' => 'yi', '二' => 'er', '三' => 'san', '四' => 'si', '五' => 'wu',
        '六' => 'liu', '七' => 'qi', '八' => 'ba', '九' => 'jiu', '十' => 'shi',
        '百' => 'bai', '千' => 'qian', '万' => 'wan', '亿' => 'yi',
        
        // Japanese
        'あ' => 'a', 'い' => 'i', 'う' => 'u', 'え' => 'e', 'お' => 'o',
        'か' => 'ka', 'き' => 'ki', 'く' => 'ku', 'け' => 'ke', 'こ' => 'ko',
        'さ' => 'sa', 'し' => 'shi', 'す' => 'su', 'せ' => 'se', 'そ' => 'so',
        'た' => 'ta', 'ち' => 'chi', 'つ' => 'tsu', 'て' => 'te', 'と' => 'to',
        'な' => 'na', 'に' => 'ni', 'ぬ' => 'nu', 'ね' => 'ne', 'の' => 'no',
        'は' => 'ha', 'ひ' => 'hi', 'ふ' => 'fu', 'へ' => 'he', 'ほ' => 'ho',
        'ま' => 'ma', 'み' => 'mi', 'む' => 'mu', 'め' => 'me', 'も' => 'mo',
        'や' => 'ya', 'ゆ' => 'yu', 'よ' => 'yo',
        'ら' => 'ra', 'り' => 'ri', 'る' => 'ru', 'れ' => 're', 'ろ' => 'ro',
        'わ' => 'wa', 'を' => 'wo', 'ん' => 'n',
    ];

    /**
     * Create a slug from a string.
     *
     * @param string $text Input text
     * @param string $separator Separator character
     * @param int $maxLength Maximum length of the slug
     * @return string Generated slug
     */
    public static function create(string $text, string $separator = '-', int $maxLength = 100): string
    {
        // Transliterate the text
        $text = self::transliterate($text);
        
        // Convert to lowercase
        $text = mb_strtolower($text, 'UTF-8');
        
        // Replace non-alphanumeric characters with separator
        $text = preg_replace('/[^a-z0-9]+/', $separator, $text);
        
        // Remove leading/trailing separators
        $text = trim($text, $separator);
        
        // Limit length
        if (mb_strlen($text) > $maxLength) {
            $text = mb_substr($text, 0, $maxLength);
            $text = rtrim($text, $separator);
        }
        
        return $text;
    }

    /**
     * Transliterate any UTF-8 script to ASCII.
     *
     * @param string $text Input text
     * @return string Transliterated text
     */
    public static function transliterate(string $text): string
    {
        $result = '';
        $length = mb_strlen($text, 'UTF-8');
        
        for ($i = 0; $i < $length; $i++) {
            $char = mb_substr($text, $i, 1, 'UTF-8');
            
            if (isset(self::TRANSLITERATION_MAP[$char])) {
                $result .= self::TRANSLITERATION_MAP[$char];
            } elseif (ord($char) < 128) {
                // Keep ASCII characters as-is
                $result .= $char;
            } else {
                // Replace unknown characters with space
                $result .= ' ';
            }
        }
        
        return $result;
    }

    /**
     * Create a slug with custom transliteration rules.
     *
     * @param string $text Input text
     * @param array $customRules Custom transliteration rules
     * @param string $separator Separator character
     * @return string Generated slug
     */
    public static function createCustom(string $text, array $customRules, string $separator = '-'): string
    {
        // Apply custom transliteration first
        foreach ($customRules as $from => $to) {
            $text = str_replace($from, $to, $text);
        }
        
        // Then apply standard transliteration
        $text = self::transliterate($text);
        
        // Convert to lowercase
        $text = mb_strtolower($text, 'UTF-8');
        
        // Replace non-alphanumeric characters with separator
        $text = preg_replace('/[^a-z0-9]+/', $separator, $text);
        
        // Remove leading/trailing separators
        $text = trim($text, $separator);
        
        return $text;
    }

    /**
     * Validate if a string is a valid slug.
     *
     * @param string $slug Slug to validate
     * @param string $separator Expected separator character
     * @return bool True if valid
     */
    public static function isValid(string $slug, string $separator = '-'): bool
    {
        $pattern = '/^[a-z0-9' . preg_quote($separator, '/') . ']+$/';
        return preg_match($pattern, $slug) === 1;
    }

    /**
     * Get available transliteration scripts.
     *
     * @return array List of supported scripts
     */
    public static function getSupportedScripts(): array
    {
        return [
            'latin' => 'Latin and Latin Extended',
            'cyrillic' => 'Cyrillic',
            'greek' => 'Greek',
            'arabic' => 'Arabic',
            'hebrew' => 'Hebrew',
            'chinese' => 'Chinese (Simplified)',
            'japanese' => 'Japanese (Hiragana)',
        ];
    }
}
