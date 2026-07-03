<?php

declare(strict_types=1);

namespace Modules\TechPlanner\Models\Traits;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Arr;
use Modules\TechPlanner\Enums\CompanyItemEnum;

/**
 * Trait HasContact.
 *
 * Fornisce funzionalità per la gestione degli indirizzi nei modelli Eloquent.
 * Questo trait implementa la relazione polimorfica con il modello Address
 * e offre metodi di utilità per la gestione degli indirizzi.
 *
 * @property Collection<int, Address> $addresses
 */
trait HasCompany
{
    /**
     * Initialize the trait
     *
     * @return void
     */
    protected function initializeHasCompany()
    {
        $fields = Arr::map(CompanyItemEnum::cases(), fn ($item) => $item->value);
        $this->mergeFillable($fields);
    }
}
