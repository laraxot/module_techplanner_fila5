<?php

declare(strict_types=1);

use Filament\Forms\Components\Field;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Modules\TechPlanner\Filament\Resources\AppointmentResource\Schemas\AppointmentForm;
use Modules\TechPlanner\Filament\Resources\DeviceResource\RelationManagers\DeviceVerificationsRelationManager;
use Modules\TechPlanner\Filament\Resources\DeviceResource\Schemas\DeviceForm;
use Modules\TechPlanner\Filament\Resources\LegalOfficeResource\Schemas\LegalOfficeForm;
use Modules\TechPlanner\Filament\Resources\LegalRepresentativeResource\Schemas\LegalRepresentativeForm;
use Modules\TechPlanner\Filament\Resources\MedicalDirectorResource\Schemas\MedicalDirectorForm;
use Modules\TechPlanner\Filament\Resources\PhoneCallResource\Schemas\PhoneCallForm;
use Modules\TechPlanner\Models\Appointment;
use Modules\TechPlanner\Models\Client;
use Modules\TechPlanner\Models\Device;
use Modules\TechPlanner\Models\DeviceVerification;
use Modules\TechPlanner\Models\LegalOffice;
use Modules\TechPlanner\Models\LegalRepresentative;
use Modules\TechPlanner\Models\MedicalDirector;
use Modules\TechPlanner\Models\PhoneCall;
use Modules\TechPlanner\Tests\TestCase;

uses(TestCase::class);

/*
 * Moduli che chiedevano colonne inesistenti (sedi legali, rappresentanti, direttori dalla scheda cliente):
 * il salvataggio falliva solo nel pannello. Ogni campo di ogni modulo deve esistere nella sua tabella,
 * creata dalle migrazioni vere, ed essere assegnabile (fillable).
 */

beforeEach(function (): void {
    $this->useIsolatedTechPlannerConnection();
    foreach ([
        '2024_12_26_000008_create_client_table.php',
        '2019_12_12_000005_create_appointments_table.php',
        '2019_12_12_000012_create_machines_table.php',
        '2026_11_05_220000_create_device_table.php',
        '2026_11_05_220010_create_device_verifications_table.php',
        '2024_12_26_000000_create_phone_call_table.php',
        '2026_11_05_220020_create_medical_directors_table.php',
        '2024_12_26_230220_create_legal_representatives_table.php',
        '2024_12_26_230221_create_legal_offices_table.php',
        '2026_11_06_100000_add_workflow_fields_to_appointments_table.php',
        '2026_11_19_000000_add_duration_minutes_to_appointments_table.php',
        '2026_11_06_000000_create_controls_table.php',
    ] as $file) {
        $migration = require dirname(__DIR__, 2).'/database/migrations/'.$file;
        expect($migration)->toBeInstanceOf(Migration::class);
        $migration->up();
    }
});

/**
 * @param  array<int|string, mixed>  $schema
 * @return list<string>
 */
function tpFieldNames(array $schema): array
{
    return array_values(array_map(
        static fn (Field $field): string => $field->getName(),
        array_filter($schema, static fn (mixed $c): bool => $c instanceof Field),
    ));
}

dataset('tp-forms', [
    'appuntamenti' => [static fn (): array => app(AppointmentForm::class)->getFormSchema(), Appointment::class],
    'chiamate' => [static fn (): array => app(PhoneCallForm::class)->getFormSchema(), PhoneCall::class],
    'direttori sanitari' => [static fn (): array => app(MedicalDirectorForm::class)->getFormSchema(), MedicalDirector::class],
    'rappresentanti legali' => [static fn (): array => app(LegalRepresentativeForm::class)->getFormSchema(), LegalRepresentative::class],
    'sedi legali' => [static fn (): array => app(LegalOfficeForm::class)->getFormSchema(), LegalOffice::class],
    'apparecchi' => [static fn (): array => app(DeviceForm::class)->getFormSchema(), Device::class],
    'verifiche' => [static fn (): array => (new DeviceVerificationsRelationManager())->getFormSchema(), DeviceVerification::class],
]);

it('asks only for columns that exist and can be saved', function (Closure $schema, string $modelClass): void {
    $model = new $modelClass();
    $fields = tpFieldNames($schema());

    expect($fields)->not->toBeEmpty();
    foreach ($fields as $field) {
        expect(Schema::connection('tech_planner')->hasColumn($model->getTable(), $field))->toBeTrue("{$modelClass}: colonna «{$field}» assente")
            ->and($model->isFillable($field))->toBeTrue("{$modelClass}: «{$field}» non è fillable");
    }
})->with('tp-forms');

it('asks for the client when the record is created from the menu', function (Closure $schema): void {
    expect(tpFieldNames($schema()))->toContain('client_id');
})->with([
    'direttori sanitari' => [static fn (): array => app(MedicalDirectorForm::class)->getFormSchema()],
    'rappresentanti legali' => [static fn (): array => app(LegalRepresentativeForm::class)->getFormSchema()],
    'sedi legali' => [static fn (): array => app(LegalOfficeForm::class)->getFormSchema()],
]);

it('has the client relation that the client picker needs', function (string $modelClass): void {
    $relation = (new $modelClass())->client();

    expect($relation)->toBeInstanceOf(BelongsTo::class)
        ->and($relation->getRelated())->toBeInstanceOf(Client::class);
})->with([Appointment::class, PhoneCall::class, MedicalDirector::class, LegalRepresentative::class, LegalOffice::class, Device::class]);
