<?php

declare(strict_types=1);

namespace Modules\TechPlanner\Filament\Imports\Concerns;

use Filament\Actions\Imports\Models\Import;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\SoftDeletingScope;

/**
 * FUN-04: reimportare lo stesso file aggiornava niente e duplicava tutto. Ora una riga aggiorna il record
 * già presente, cercato per chiavi in ordine di affidabilità (es. id di Access, poi partita IVA): solo se
 * nessuna chiave trova qualcosa si crea un record nuovo. Un record nel cestino ritrovato dal file torna attivo.
 *
 * @property array<string, mixed> $data
 */
trait ResolvesExistingRecord
{
    /**
     * Colonne del file che identificano un record già presente, dalla più affidabile.
     *
     * @return list<string>
     */
    abstract protected function matchingKeys(): array;

    protected function resolveExistingRecord(): Model
    {
        /** @var class-string<Model> $modelClass */
        $modelClass = static::getModel();
        $softDeletes = \in_array(SoftDeletes::class, class_uses_recursive($modelClass), true);

        foreach ($this->matchingKeys() as $key) {
            $value = $this->data[$key] ?? null;
            if ($value === null || $value === '' || (! \is_string($value) && ! \is_int($value))) {
                continue;
            }

            $query = $modelClass::query();
            if ($softDeletes) {
                $query->withoutGlobalScope(SoftDeletingScope::class);
            }
            $record = $query->where($key, $value)->first();
            if ($record instanceof Model) {
                if (method_exists($record, 'trashed') && method_exists($record, 'restore') && $record->trashed()) {
                    $record->restore();
                }

                return $record;
            }
        }

        return new $modelClass();
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = trans_choice('techplanner::import.completed', $import->successful_rows, ['count' => number_format($import->successful_rows, 0, ',', '.')]);

        $failed = $import->getFailedRowsCount();
        if ($failed > 0) {
            $body .= ' '.trans_choice('techplanner::import.failed', $failed, ['count' => number_format($failed, 0, ',', '.')]);
        }

        return $body;
    }
}
