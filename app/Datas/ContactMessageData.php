<?php

declare(strict_types=1);

namespace Modules\TechPlanner\Datas;

use Spatie\LaravelData\Data;

/**
 * Messaggio del form di contatto gia' validato. Nomi dei campi del form in italiano (contratto del blocco
 * `contact.form`), proprieta' in inglese.
 */
final class ContactMessageData extends Data
{
    public function __construct(
        public readonly string $name,
        public readonly string $email,
        public readonly string $message,
        public readonly ?string $phone = null,
        public readonly ?string $studio = null,
        public readonly ?string $type = null,
    ) {}

    /**
     * @return array<string, list<string>>
     */
    public static function formRules(): array
    {
        return [
            'nome' => ['required', 'string', 'max:120'],
            'email' => ['required', 'string', 'email', 'max:190'],
            'telefono' => ['nullable', 'string', 'max:40', 'regex:/^[0-9+().\s\/-]+$/'],
            'studio' => ['nullable', 'string', 'max:150'],
            'tipo' => ['nullable', 'string', 'max:100'],
            'messaggio' => ['required', 'string', 'max:5000'],
            'privacy' => ['accepted'],
        ];
    }

    /**
     * @param  array<string, mixed>  $validated  risultato di `formRules()`
     */
    public static function fromValidated(array $validated): self
    {
        $text = static fn (string $key): ?string => isset($validated[$key]) && is_string($validated[$key]) && trim($validated[$key]) !== ''
            ? trim($validated[$key])
            : null;

        return new self(
            name: $text('nome') ?? '',
            email: $text('email') ?? '',
            message: $text('messaggio') ?? '',
            phone: $text('telefono'),
            studio: $text('studio'),
            type: $text('tipo'),
        );
    }
}
