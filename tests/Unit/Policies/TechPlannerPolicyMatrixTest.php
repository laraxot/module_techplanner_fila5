<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Gate;
use Modules\TechPlanner\Models\Client;
use Modules\TechPlanner\Models\Device;
use Modules\TechPlanner\Models\DeviceVerification;
use Modules\TechPlanner\Models\Policies\ClientPolicy;
use Modules\TechPlanner\Models\Policies\DevicePolicy;
use Modules\TechPlanner\Models\Policies\DeviceVerificationPolicy;
use Modules\TechPlanner\Models\Policies\TechPlannerBasePolicy;
use Modules\TechPlanner\Tests\TestCase;
use Modules\Xot\Contracts\UserContract;

uses(TestCase::class);

/*
 * TPL-04: senza policy chiunque entrasse nel pannello poteva cancellare clienti, apparecchi e verifiche.
 * Matrice ruolo × abilità, senza database: l'utente risponde a hasRole() come uno Spatie reale.
 */

/** @param list<string> $roles */
function tpUser(array $roles): UserContract
{
    $user = Mockery::mock(UserContract::class);
    $user->shouldReceive('hasRole')->andReturnUsing(
        static fn (string|array $wanted): bool => array_intersect((array) $wanted, $roles) !== [],
    );

    return $user;
}

dataset('tp-policies', [
    'clienti' => [ClientPolicy::class, Client::class],
    'apparecchi' => [DevicePolicy::class, Device::class],
    'verifiche' => [DeviceVerificationPolicy::class, DeviceVerification::class],
]);

it('lets the admin role do everything', function (string $policyClass, string $modelClass): void {
    $policy = new $policyClass();
    $user = tpUser([TechPlannerBasePolicy::ROLE_ADMIN]);
    $record = new $modelClass();

    expect($policy->viewAny($user))->toBeTrue()
        ->and($policy->view($user, $record))->toBeTrue()
        ->and($policy->create($user))->toBeTrue()
        ->and($policy->update($user, $record))->toBeTrue()
        ->and($policy->delete($user, $record))->toBeTrue()
        ->and($policy->deleteAny($user))->toBeTrue()
        ->and($policy->forceDelete($user, $record))->toBeTrue();
})->with('tp-policies');

it('lets the operator work but not delete', function (string $policyClass, string $modelClass): void {
    $policy = new $policyClass();
    $user = tpUser([TechPlannerBasePolicy::ROLE_OPERATOR]);
    $record = new $modelClass();

    expect($policy->viewAny($user))->toBeTrue()
        ->and($policy->view($user, $record))->toBeTrue()
        ->and($policy->create($user))->toBeTrue()
        ->and($policy->update($user, $record))->toBeTrue()
        ->and($policy->delete($user, $record))->toBeFalse()
        ->and($policy->deleteAny($user))->toBeFalse()
        ->and($policy->restore($user, $record))->toBeFalse()
        ->and($policy->forceDelete($user, $record))->toBeFalse();
})->with('tp-policies');

it('denies users without a TechPlanner role', function (string $policyClass, string $modelClass): void {
    $policy = new $policyClass();
    $user = tpUser(['user::admin']);
    $record = new $modelClass();

    expect($policy->viewAny($user))->toBeFalse()
        ->and($policy->view($user, $record))->toBeFalse()
        ->and($policy->create($user))->toBeFalse()
        ->and($policy->update($user, $record))->toBeFalse()
        ->and($policy->delete($user, $record))->toBeFalse();
})->with('tp-policies');

it('lets the super-admin through before any ability', function (): void {
    expect((new ClientPolicy())->before(tpUser(['super-admin']), 'delete'))->toBeTrue()
        ->and((new ClientPolicy())->before(tpUser([TechPlannerBasePolicy::ROLE_OPERATOR]), 'delete'))->toBeNull();
});

it('is discovered by the gate for every panel model', function (string $policyClass, string $modelClass): void {
    expect(Gate::getPolicyFor($modelClass))->toBeInstanceOf($policyClass);
})->with('tp-policies');
