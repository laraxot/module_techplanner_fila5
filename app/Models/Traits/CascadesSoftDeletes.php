<?php

declare(strict_types=1);

namespace Modules\TechPlanner\Models\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Carbon;

/**
 * Cestino a cascata: quando un record va nel cestino ci vanno anche i figli elencati in
 * {@see softDeleteCascades()}; quando torna, tornano i figli finiti nel cestino con lui
 * (stesso momento o dopo), non quelli eliminati prima per conto loro.
 *
 * La cancellazione definitiva resta affidata alle foreign key `ON DELETE CASCADE`.
 * Il modello che usa questo trait deve usare anche SoftDeletes.
 *
 * @phpstan-require-extends Model
 */
trait CascadesSoftDeletes
{
    /** Momento in cui il record era finito nel cestino, letto prima del ripristino. */
    private ?Carbon $cascadeTrashedAt = null;

    /**
     * Relazioni HasMany da portare nel cestino insieme al record.
     *
     * @return list<string>
     */
    abstract protected function softDeleteCascades(): array;

    public static function bootCascadesSoftDeletes(): void
    {
        static::deleted(static function (self $model): void {
            if (! \in_array(SoftDeletes::class, class_uses_recursive($model), true) || $model->isForceDeleting()) {
                return;
            }

            foreach ($model->cascadeRelations() as $relation) {
                foreach ($relation->get() as $child) {
                    $child->delete();
                }
            }
        });

        static::restoring(static function (self $model): void {
            $trashedAt = $model->getAttribute('deleted_at');
            $model->cascadeTrashedAt = $trashedAt instanceof Carbon ? $trashedAt->copy() : null;
        });

        static::restored(static function (self $model): void {
            $trashedAt = $model->cascadeTrashedAt;
            $model->cascadeTrashedAt = null;
            if ($trashedAt === null) {
                return;
            }

            foreach ($model->cascadeRelations() as $relation) {
                $deletedAt = $relation->getRelated()->qualifyColumn('deleted_at');
                $children = $relation->getQuery()
                    ->withoutGlobalScope(SoftDeletingScope::class)
                    ->where($deletedAt, '>=', $trashedAt)
                    ->get();
                foreach ($children as $child) {
                    if (method_exists($child, 'restore')) {
                        $child->restore();
                    }
                }
            }
        });
    }

    /**
     * Le relazioni dichiarate, solo se portano a modelli con cestino.
     *
     * @return list<HasMany<Model, Model>>
     */
    private function cascadeRelations(): array
    {
        $relations = [];
        foreach ($this->softDeleteCascades() as $name) {
            $relation = $this->{$name}();
            if ($relation instanceof HasMany && \in_array(SoftDeletes::class, class_uses_recursive($relation->getRelated()), true)) {
                /** @var HasMany<Model, Model> $relation */
                $relations[] = $relation;
            }
        }

        return $relations;
    }
}
