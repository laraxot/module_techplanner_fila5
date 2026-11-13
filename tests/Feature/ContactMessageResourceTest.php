<?php

declare(strict_types=1);

use Modules\TechPlanner\Enums\ContactMessageStatusEnum;
use Modules\TechPlanner\Filament\Resources\ContactMessageResource;
use Modules\TechPlanner\Filament\Resources\ContactMessageResource\Tables\ContactMessagesTable;
use Modules\TechPlanner\Models\ContactMessage;
use Modules\TechPlanner\Models\Policies\ContactMessagePolicy;
use Modules\TechPlanner\Models\Policies\TechPlannerBasePolicy;
use Modules\TechPlanner\Tests\TestCase;
use Modules\Xot\Contracts\UserContract;

uses(TestCase::class);

/*
 * FUN-09: le richieste del modulo «Contatti» del sito si leggono nel pannello; non si creano né si modificano.
 */

function tpContactUser(string $role): UserContract
{
    $user = Mockery::mock(UserContract::class);
    $user->shouldReceive('hasRole')->andReturnUsing(static fn (string|array $wanted): bool => in_array($role, (array) $wanted, true));

    return $user;
}

it('offers only the list and the detail page', function (): void {
    expect(array_keys(ContactMessageResource::getPages()))->toBe(['index', 'view']);
});

it('lets staff read but nobody create or edit from the panel', function (): void {
    $policy = new ContactMessagePolicy();
    $operator = tpContactUser(TechPlannerBasePolicy::ROLE_OPERATOR);
    $admin = tpContactUser(TechPlannerBasePolicy::ROLE_ADMIN);
    $message = new ContactMessage();

    expect($policy->viewAny($operator))->toBeTrue()
        ->and($policy->view($operator, $message))->toBeTrue()
        ->and($policy->create($admin))->toBeFalse()
        ->and($policy->update($admin, $message))->toBeFalse()
        ->and($policy->delete($operator, $message))->toBeFalse()
        ->and($policy->delete($admin, $message))->toBeTrue();
});

it('shows only the view action and a status filter in Italian', function (): void {
    app()->setLocale('it');
    $table = new ContactMessagesTable();

    expect(array_keys($table->getTableActions()))->toBe(['view'])
        ->and($table->getTableBulkActions())->toBe([])
        ->and(ContactMessageStatusEnum::options())->toBe([
            'pending' => 'Da inoltrare',
            'forwarded' => 'Inoltrata per e-mail',
            'forward_failed' => 'Inoltro fallito',
        ]);
});
