<?php

declare(strict_types=1);

namespace Modules\TechPlanner\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

use function Safe\preg_match;
use function Safe\preg_replace;

/**
 * Codice fiscale italiano: 16 caratteri di una persona (con carattere di controllo, omocodie comprese)
 * oppure 11 cifre di una società (stesso controllo della partita IVA). FUN-05.
 */
final class ItalianFiscalCodeRule implements ValidationRule
{
    private const string ODD = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';

    /** Valori dei caratteri in posizione dispari (1ª, 3ª, …), nell'ordine di self::ODD. */
    private const array ODD_VALUES = [
        1, 0, 5, 7, 9, 13, 15, 17, 19, 21,
        1, 0, 5, 7, 9, 13, 15, 17, 19, 21, 2, 4, 18, 20, 11, 3, 6, 8, 12, 14, 16, 10, 22, 25, 24, 23,
    ];

    private const string PERSON_PATTERN = '/^[A-Z]{6}[0-9LMNPQRSTUV]{2}[ABCDEHLMPRST][0-9LMNPQRSTUV]{2}[A-Z][0-9LMNPQRSTUV]{3}[A-Z]$/';

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if ($value === null || $value === '') {
            return;
        }

        if (! is_string($value) || ! self::isValid($value)) {
            $fail(__('techplanner::validation.fiscal_code'));
        }
    }

    public static function isValid(string $value): bool
    {
        $code = strtoupper((string) preg_replace('/\s+/', '', $value));

        if (preg_match('/^\d{11}$/', $code) === 1) {
            return ItalianVatNumberRule::isValid($code);
        }

        if (preg_match(self::PERSON_PATTERN, $code) !== 1) {
            return false;
        }

        $sum = 0;
        for ($i = 0; $i < 15; $i++) {
            $char = $code[$i];
            $sum += $i % 2 === 0
                ? self::ODD_VALUES[strpos(self::ODD, $char)]
                : (ctype_digit($char) ? (int) $char : ord($char) - 65);
        }

        return chr(65 + $sum % 26) === $code[15];
    }
}
