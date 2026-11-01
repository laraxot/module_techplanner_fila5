<?php

declare(strict_types=1);

namespace Modules\TechPlanner\Actions\Contact;

use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Modules\TechPlanner\Datas\ContactMessageData;

/**
 * Inoltra il messaggio alla casella del titolare, in modo sincrono (l'esito deve essere vero, non in coda).
 * Nulla viene salvato sul server: il messaggio vive solo nella casella di destinazione. Lancia se il trasporto fallisce.
 * L'oggetto e' fisso: nessun testo dell'utente finisce nelle intestazioni.
 */
class SendContactMessageAction
{
    public function execute(ContactMessageData $data, string $recipient, string $pageLocale): void
    {
        $body = $this->body($data, $pageLocale);
        $subject = trans('techplanner::contact_message.mail.subject.label');
        $replyToName = Str::of($data->name)->replaceMatches('/[\x00-\x1F\x7F]+/u', ' ')->trim()->toString();

        Mail::raw($body, static function (Message $mail) use ($recipient, $subject, $data, $replyToName): void {
            $mail->to($recipient)
                ->replyTo($data->email, $replyToName)
                ->subject(is_string($subject) ? $subject : 'Contact form');
        });
    }

    private function body(ContactMessageData $data, string $pageLocale): string
    {
        $label = static fn (string $field): string => (string) trans('techplanner::contact_message.mail.fields.'.$field.'.label');

        $lines = [
            (string) trans('techplanner::contact_message.mail.intro.message'),
            '',
            $label('name').': '.$data->name,
            $label('email').': '.$data->email,
        ];
        foreach (['phone' => $data->phone, 'studio' => $data->studio, 'type' => $data->type] as $field => $value) {
            if ($value !== null) {
                $lines[] = $label($field).': '.$value;
            }
        }
        $lines[] = $label('page_locale').': '.$pageLocale;
        $lines[] = $label('privacy').': '.trans('techplanner::contact_message.mail.privacy_seen.message', ['when' => now()->toIso8601String()]);
        $lines[] = '';
        $lines[] = $label('message').':';
        $lines[] = $data->message;

        return implode("\n", $lines);
    }
}
