<?php

declare(strict_types=1);

use Illuminate\Mail\Transport\ArrayTransport;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Mockery\MockInterface;
use Modules\TechPlanner\Actions\Contact\DeliverContactMessageAction;
use Modules\TechPlanner\Actions\Contact\SendContactMessageAction;
use Modules\TechPlanner\Actions\Contact\StoreContactMessageAction;
use Modules\TechPlanner\Actions\Contact\UpdateContactMessageStatusAction;
use Modules\TechPlanner\Datas\ContactMessageData;
use Modules\TechPlanner\Enums\ContactMessageStatusEnum;
use Modules\TechPlanner\Enums\ContactOutcomeEnum;
use Modules\TechPlanner\Models\ContactMessage;
use Modules\TechPlanner\Tests\TestCase;
use Symfony\Component\Mailer\SentMessage;
use Symfony\Component\Mime\Email;

uses(TestCase::class);

/*
 * Esiti del form di contatto senza database reale ne' posta reale: archivio e stato sono sostituiti nel container,
 * la posta e' `Mail::fake()`. Verifica la regola di prodotto: "inviato" solo se l'inoltro e' riuscito.
 */

/**
 * @param  bool  $storeFails  l'archivio lancia
 * @param  bool  $sendFails  l'inoltro e-mail lancia
 * @param  list<ContactMessageStatusEnum>  $statuses  riempito con gli stati scritti
 */
function bindContactFakes(bool $storeFails, bool $sendFails, array &$statuses): void
{
    app()->instance(StoreContactMessageAction::class, new class($storeFails) extends StoreContactMessageAction
    {
        public function __construct(private readonly bool $fails) {}

        public function execute(ContactMessageData $data, string $locale): ContactMessage
        {
            if ($this->fails) {
                throw new RuntimeException('database down');
            }

            return new ContactMessage(['name' => $data->name, 'locale' => $locale]);
        }
    });

    app()->instance(UpdateContactMessageStatusAction::class, new class($statuses) extends UpdateContactMessageStatusAction
    {
        /** @param  list<ContactMessageStatusEnum>  $statuses */
        public function __construct(private array &$statuses) {}

        public function execute(ContactMessage $message, ContactMessageStatusEnum $status): void
        {
            $this->statuses = [...$this->statuses, $status];
        }
    });

    if ($sendFails) {
        app()->instance(SendContactMessageAction::class, new class() extends SendContactMessageAction
        {
            public function execute(ContactMessageData $data, string $recipient, string $pageLocale): void
            {
                throw new RuntimeException('smtp down');
            }
        });
    }
}

function contactMessageData(): ContactMessageData
{
    return new ContactMessageData(name: 'Mario Rossi', email: 'mario@example.test', message: 'Vorrei un preventivo.');
}

/**
 * @return list<SentMessage>
 */
function contactMailsSent(): array
{
    $transport = Mail::mailer('array')->getSymfonyTransport();

    if (! $transport instanceof ArrayTransport) {
        return [];
    }

    return array_values(array_filter(
        $transport->messages()->all(),
        static fn (mixed $message): bool => $message instanceof SentMessage,
    ));
}

beforeEach(function (): void {
    config(['mail.default' => 'array']);
    Mail::forgetMailers();
    Log::spy();
});

it('says sent and records Forwarded when the mail goes out', function (): void {
    config(['techplanner.contact.recipient' => 'destinatario@example.test']);
    $statuses = [];
    bindContactFakes(false, false, $statuses);

    $outcome = app(DeliverContactMessageAction::class)->execute(contactMessageData(), 'it');

    expect($outcome)->toBe(ContactOutcomeEnum::Sent)
        ->and($statuses)->toBe([ContactMessageStatusEnum::Forwarded])
        ->and(contactMailsSent())->toHaveCount(1);
});

it('says received, never sent, when the recipient is not configured', function (): void {
    config(['techplanner.contact.recipient' => null]);
    $statuses = [];
    bindContactFakes(false, false, $statuses);

    $outcome = app(DeliverContactMessageAction::class)->execute(contactMessageData(), 'it');

    expect($outcome)->toBe(ContactOutcomeEnum::Received)
        ->and($statuses)->toBe([])
        ->and(contactMailsSent())->toBe([]);
});

it('keeps the stored message and says received when the mail transport fails', function (): void {
    config(['techplanner.contact.recipient' => 'destinatario@example.test']);
    $statuses = [];
    bindContactFakes(false, true, $statuses);

    $outcome = app(DeliverContactMessageAction::class)->execute(contactMessageData(), 'it');

    expect($outcome)->toBe(ContactOutcomeEnum::Received)
        ->and($statuses)->toBe([ContactMessageStatusEnum::ForwardFailed]);
});

it('says sent when only the archive fails but the mail went out', function (): void {
    config(['techplanner.contact.recipient' => 'destinatario@example.test']);
    $statuses = [];
    bindContactFakes(true, false, $statuses);

    expect(app(DeliverContactMessageAction::class)->execute(contactMessageData(), 'it'))->toBe(ContactOutcomeEnum::Sent)
        ->and($statuses)->toBe([]);
});

it('fails when neither the archive nor the mail works', function (bool $recipientConfigured): void {
    config(['techplanner.contact.recipient' => $recipientConfigured ? 'destinatario@example.test' : null]);
    $statuses = [];
    bindContactFakes(true, true, $statuses);

    expect(app(DeliverContactMessageAction::class)->execute(contactMessageData(), 'it'))->toBe(ContactOutcomeEnum::Failed);
})->with([
    'recipient set' => [true],
    'recipient missing' => [false],
]);

it('logs only the exception class, never the sender data', function (): void {
    config(['techplanner.contact.recipient' => 'destinatario@example.test']);
    $statuses = [];
    bindContactFakes(true, true, $statuses);

    app(DeliverContactMessageAction::class)->execute(contactMessageData(), 'it');

    $logger = Log::getFacadeRoot();
    expect($logger)->toBeInstanceOf(MockInterface::class);
    if (! $logger instanceof MockInterface) {
        throw new RuntimeException('Log facade is not backed by the expected spy.');
    }
    $logger->shouldHaveReceived('error')->twice()->withArgs(
        static fn (string $message, array $context): bool => $context === ['exception' => RuntimeException::class]
            && ! str_contains($message, 'mario'),
    );
});

it('sends a plain text mail with a fixed subject and the sender as reply-to', function (): void {
    $data = new ContactMessageData(name: "Mario\r\nBcc: x@example.test", email: 'mario@example.test', message: 'Vorrei un preventivo.', phone: '+39 041 455552');

    app(SendContactMessageAction::class)->execute($data, 'destinatario@example.test', 'it');

    $sent = contactMailsSent();
    expect($sent)->toHaveCount(1);

    $email = $sent[0]->getOriginalMessage();
    expect($email)->toBeInstanceOf(Email::class);
    assert($email instanceof Email);
    expect($email->getTo()[0]->getAddress())->toBe('destinatario@example.test')
        ->and($email->getReplyTo()[0]->getAddress())->toBe('mario@example.test')
        ->and($email->getSubject())->toBe('Nuovo messaggio dal modulo di contatto del sito')
        ->and($email->getBcc())->toBe([])
        ->and((string) $email->getTextBody())->toContain('Vorrei un preventivo.')->toContain('+39 041 455552');
});
