<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\ViewErrorBag;
use Illuminate\Testing\TestResponse;
use Modules\TechPlanner\Actions\Contact\PurgeExpiredContactMessagesAction;
use Modules\TechPlanner\Actions\Contact\StoreContactMessageAction;
use Modules\TechPlanner\Actions\Contact\UpdateContactMessageStatusAction;
use Modules\TechPlanner\Enums\ContactMessageStatusEnum;
use Modules\TechPlanner\Models\ContactMessage;
use Modules\TechPlanner\Tests\TestCase;
use Modules\TechPlanner\Tests\Unit\Actions\Contact\TechPlannerContactStoreFake;
use PHPUnit\Framework\Assert;
use Symfony\Component\HttpFoundation\Response;

uses(TestCase::class);

/*
 * POST del form di contatto attraverso il router (sessione, validazione, redirect), senza database ne' posta reali:
 * archivio e stato sono sostituiti nel container e la posta usa il trasporto `array`.
 */

/** @return array<string, mixed> */
function validContactPayload(): array
{
    return [
        'nome' => 'Mario Rossi',
        'email' => 'mario@example.test',
        'telefono' => '+39 041 455552',
        'studio' => 'Studio Esempio',
        'tipo' => 'Odontoiatrico',
        'messaggio' => 'Vorrei un preventivo.',
        'privacy' => '1',
    ];
}

/**
 * @param  array<string, mixed>  $payload
 * @return TestResponse<Response>
 */
function postContactForm(TestCase $test, array $payload): TestResponse
{
    return $test->from('/it/contacts')->post(route('techplanner.contact.submit', ['lang' => 'it']), $payload);
}

beforeEach(function (): void {
    config(['mail.default' => 'array', 'techplanner.contact.recipient' => 'destinatario@example.test']);
    Mail::forgetMailers();

    $store = new TechPlannerContactStoreFake();
    app()->instance(TechPlannerContactStoreFake::class, $store);
    app()->instance(StoreContactMessageAction::class, $store);
    app()->instance(UpdateContactMessageStatusAction::class, new class() extends UpdateContactMessageStatusAction
    {
        public function execute(ContactMessage $message, ContactMessageStatusEnum $status): void {}
    });
});

it('is a named POST route in the web group with a throttle', function (): void {
    $route = app('router')->getRoutes()->getByName('techplanner.contact.submit');

    expect($route)->not->toBeNull()
        ->and($route?->methods())->toContain('POST')
        ->and($route?->gatherMiddleware())->toContain('web')
        ->and($route?->gatherMiddleware())->toContain('throttle:5,10');
});

it('stores, forwards and flashes sent for a valid message', function (): void {
    $response = postContactForm($this, validContactPayload());

    $response->assertRedirect('/it/contacts#contact-form-feedback')
        ->assertSessionHas('contact_outcome', 'sent')
        ->assertSessionHasNoErrors();
    expect(app(TechPlannerContactStoreFake::class)->storedCount())->toBe(1);
});

it('flashes received, not sent, when the recipient is not configured', function (): void {
    config(['techplanner.contact.recipient' => null]);

    postContactForm($this, validContactPayload())->assertSessionHas('contact_outcome', 'received');
});

it('answers a filled honeypot like a success but stores and sends nothing', function (): void {
    $response = postContactForm($this, validContactPayload() + ['website' => 'https://spam.example.test']);

    $response->assertSessionHas('contact_outcome', 'sent');
    expect(app(TechPlannerContactStoreFake::class)->storedCount())->toBe(0);
});

it('rejects missing or malformed fields with errors on the right fields and repopulates the rest', function (): void {
    $payload = ['nome' => 'Mario Rossi', 'email' => 'non-una-email', 'messaggio' => '', 'telefono' => 'abc'];

    $response = postContactForm($this, $payload);

    $response->assertSessionHasErrors(['email', 'messaggio', 'telefono', 'privacy'])
        ->assertSessionHasInput('nome', 'Mario Rossi')
        ->assertSessionMissing('contact_outcome');
    expect(app(TechPlannerContactStoreFake::class)->storedCount())->toBe(0);
});

it('shows readable Italian messages, never raw validation keys', function (): void {
    postContactForm($this, ['nome' => str_repeat('a', 121), 'email' => 'x', 'telefono' => 'abc']);

    $errors = session('errors');
    Assert::assertInstanceOf(ViewErrorBag::class, $errors);
    expect($errors->first('privacy'))->toBe('Per inviare il messaggio devi accettare l\'informativa sulla privacy.')
        ->and($errors->first('messaggio'))->toBe('Il campo Messaggio è obbligatorio.')
        ->and($errors->first('email'))->toBe('Il campo Email deve contenere un indirizzo e-mail valido.')
        ->and($errors->first('telefono'))->toBe('Il campo Telefono contiene caratteri non validi.')
        ->and($errors->first('nome'))->toBe('Il campo Nome e cognome è troppo lungo.');
});

it('keeps the purge inert until the data controller sets a positive number of days', function (mixed $configured): void {
    config(['techplanner.contact.retention_days' => $configured]);

    expect(app(PurgeExpiredContactMessagesAction::class)->retentionDays())->toBeNull()
        ->and(app(PurgeExpiredContactMessagesAction::class)->execute())->toBeNull();
})->with([
    'unset' => [null],
    'empty' => [''],
    'text' => ['presto'],
    'zero' => ['0'],
    'negative' => ['-5'],
]);

it('reads the retention once the data controller sets it', function (): void {
    config(['techplanner.contact.retention_days' => '90']);

    expect(app(PurgeExpiredContactMessagesAction::class)->retentionDays())->toBe(90);
});

it('casts the archived status to the enum', function (): void {
    expect((new ContactMessage(['status' => 'forward_failed']))->status)->toBe(ContactMessageStatusEnum::ForwardFailed);
});
