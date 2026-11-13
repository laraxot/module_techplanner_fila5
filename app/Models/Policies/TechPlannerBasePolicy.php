<?php

declare(strict_types=1);

namespace Modules\TechPlanner\Models\Policies;

use Illuminate\Database\Eloquent\Model;
use Modules\Xot\Contracts\UserContract;
use Modules\Xot\Models\Policies\XotBasePolicy;

/**
 * Permessi del pannello TechPlanner, per ruolo.
 *
 * - `techplanner::admin`: tutto, comprese cancellazione, ripristino e cancellazione definitiva.
 * - `techplanner::operator` (segreteria, tecnici): consulta, crea e modifica; non cancella.
 * - `super-admin`: tutto, tramite {@see XotBasePolicy::before()}.
 *
 * Senza policy Filament permetteva ogni azione a chiunque entrasse nel pannello (TPL-04).
 */
abstract class TechPlannerBasePolicy extends XotBasePolicy
{
    public const string ROLE_ADMIN = 'techplanner::admin';

    public const string ROLE_OPERATOR = 'techplanner::operator';

    public function viewAny(UserContract $user): bool
    {
        return $this->isStaff($user);
    }

    public function view(UserContract $user, Model $_record): bool
    {
        return $this->isStaff($user);
    }

    public function create(UserContract $user): bool
    {
        return $this->isStaff($user);
    }

    public function update(UserContract $user, Model $_record): bool
    {
        return $this->isStaff($user);
    }

    public function replicate(UserContract $user, Model $_record): bool
    {
        return $this->isStaff($user);
    }

    public function delete(UserContract $user, Model $_record): bool
    {
        return $this->isAdmin($user);
    }

    public function deleteAny(UserContract $user): bool
    {
        return $this->isAdmin($user);
    }

    public function restore(UserContract $user, Model $_record): bool
    {
        return $this->isAdmin($user);
    }

    public function restoreAny(UserContract $user): bool
    {
        return $this->isAdmin($user);
    }

    public function forceDelete(UserContract $user, Model $_record): bool
    {
        return $this->isAdmin($user);
    }

    public function forceDeleteAny(UserContract $user): bool
    {
        return $this->isAdmin($user);
    }

    public function reorder(UserContract $user): bool
    {
        return $this->isAdmin($user);
    }

    /** Collegare un record esistente da una scheda (relation manager). */
    public function associate(UserContract $user): bool
    {
        return $this->isStaff($user);
    }

    public function associateAny(UserContract $user): bool
    {
        return $this->isStaff($user);
    }

    public function dissociate(UserContract $user, Model $_record): bool
    {
        return $this->isStaff($user);
    }

    public function dissociateAny(UserContract $user): bool
    {
        return $this->isStaff($user);
    }

    public function attach(UserContract $user): bool
    {
        return $this->isStaff($user);
    }

    public function attachAny(UserContract $user): bool
    {
        return $this->isStaff($user);
    }

    public function detach(UserContract $user, Model $_record): bool
    {
        return $this->isStaff($user);
    }

    public function detachAny(UserContract $user): bool
    {
        return $this->isStaff($user);
    }

    protected function isStaff(UserContract $user): bool
    {
        return $user->hasRole([self::ROLE_ADMIN, self::ROLE_OPERATOR]);
    }

    protected function isAdmin(UserContract $user): bool
    {
        return $user->hasRole(self::ROLE_ADMIN);
    }
}
