<?php

declare(strict_types=1);

namespace Modules\TechPlanner\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

use function Safe\preg_match;
use function Safe\preg_replace;

/**
 * Partita IVA italiana: 11 cifre con cifra di controllo (algoritmo di Luhn). Accetta spazi e il prefisso «IT».
 * FUN-05: prima si salvava qualunque testo, e gli errori di battitura emergevano solo in fattura.
 */
final class ItalianVatNumberRule implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if ($value === null || $value === '') {
            return;
        }

        if (! is_string($value) || ! self::isValid($value)) {
            $fail(__('techplanner::validation.vat_number'));
        }
    }

    public static function normalize(string $value): string
    {
        $value = strtoupper((string) preg_replace('/\s+/', '', $value));

        return str_starts_with($value, 'IT') ? substr($value, 2) : $value;
    }

    public static function isValid(string $value): bool
    {
        $digits = self::normalize($value);
        if (preg_match('/^\d{11}$/', $digits) !== 1) {
            return false;
        }

        $sum = 0;
        for ($i = 0; $i < 10; $i++) {
            $digit = (int) $digits[$i];
            if ($i % 2 === 1) {
                $digit *= 2;
                $digit = $digit > 9 ? $digit - 9 : $digit;
            }
            $sum += $digit;
        }

        return (10 - $sum % 10) % 10 === (int) $digits[10];
    }
}
