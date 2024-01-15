<?php

declare(strict_types=1);

namespace Core;

/**
 * Validates various inputs.
 */
class Validator
{
    /**
     * Ensures a string fits the correct parameters.
     * 
     * @param string $value The value to check.
     * @param int $min The minimum required length.
     *     Defaults to 1.
     * @param int $max The maximum required length.
     *     Defaults to 255.
     * 
     * @return bool
     */
    public static function isString(string $value, int $min = 1, int $max = 255): bool
    {
        $value = trim($value);

        return strlen($value) >= $min && strlen($value) <= $max;
    }

    /**
     * Checks a string is in the correct email format.
     * 
     * @param string $value The value to check.
     * 
     * @retrun bool
     */
    public static function isEmail(string $value): bool
    {
        return (bool) filter_var($value, FILTER_VALIDATE_EMAIL);
    }
}