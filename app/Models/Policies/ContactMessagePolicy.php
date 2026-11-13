<?php

declare(strict_types=1);

namespace Modules\TechPlanner\Models\Policies;

use Illuminate\Database\Eloquent\Model;
use Modules\Xot\Contracts\UserContract;
use Override;

/**
 * Le richieste dal sito si leggono e si cancellano (amministratore), non si creano né si modificano dal pannello.
 */
class ContactMessagePolicy extends TechPlannerBasePolicy
{
    #[Override]
    public function create(UserContract $user): bool
    {
        return false;
    }

    #[Override]
    public function update(UserContract $user, Model $_record): bool
    {
        return false;
    }

    #[Override]
    public function replicate(UserContract $user, Model $_record): bool
    {
        return false;
    }
}
