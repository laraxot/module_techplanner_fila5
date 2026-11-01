<?php

declare(strict_types=1);

namespace Modules\TechPlanner\Actions\Contact;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Modules\TechPlanner\Datas\ContactMessageData;
use Modules\TechPlanner\Enums\ContactOutcomeEnum;

/**
 * POST del blocco `contact.form` (rotta `techplanner.contact.submit`, con throttle e CSRF del gruppo `web`).
 *
 * Ordine: honeypot -> validazione -> archivio e inoltro (DeliverContactMessageAction). Ogni esito torna alla pagina di
 * provenienza con un solo dato di sessione (`contact_outcome`) oppure con gli errori di validazione. La risposta
 * all'honeypot e' identica a quella di un invio riuscito, cosi' un bot non impara nulla.
 */
final class SubmitContactFormAction
{
    public const string HONEYPOT_FIELD = 'website';

    public const string FEEDBACK_FRAGMENT = 'contact-form-feedback';

    /** @var list<string> */
    private const array REPOPULATED_FIELDS = ['nome', 'email', 'telefono', 'studio', 'tipo', 'messaggio'];

    public function __construct(private readonly DeliverContactMessageAction $deliver) {}

    public function __invoke(Request $request): RedirectResponse
    {
        $back = redirect()->to(url()->previous())->withFragment(self::FEEDBACK_FRAGMENT);

        if ($request->filled(self::HONEYPOT_FIELD)) {
            return $back->with('contact_outcome', ContactOutcomeEnum::Sent->value);
        }

        $validator = Validator::make($request->all(), ContactMessageData::formRules(), $this->messages(), $this->attributeNames());
        if ($validator->fails()) {
            return $back
                ->withErrors($validator)
                ->withInput($request->only(self::REPOPULATED_FIELDS));
        }

        $validated = [];
        foreach ($validator->validated() as $key => $value) {
            if (is_string($key)) {
                $validated[$key] = $value;
            }
        }

        $outcome = $this->deliver->execute(
            ContactMessageData::fromValidated($validated),
            $this->pageLocale($request),
        );

        $back->with('contact_outcome', $outcome->value);

        return $outcome === ContactOutcomeEnum::Failed
            ? $back->withInput($request->only(self::REPOPULATED_FIELDS))
            : $back;
    }

    /**
     * @return array<string, string>
     */
    private function attributeNames(): array
    {
        $names = [];
        foreach (array_keys(ContactMessageData::formRules()) as $field) {
            $names[$field] = (string) trans('techplanner::contact_validation.attributes.'.$field.'.label');
        }

        return $names;
    }

    /**
     * L'app non ha un catalogo `validation.*` in italiano: senza questi testi l'utente leggerebbe la chiave grezza.
     *
     * @return array<string, string>
     */
    private function messages(): array
    {
        $text = static fn (string $rule): string => (string) trans('techplanner::contact_validation.rules.'.$rule.'.message');

        return [
            'required' => $text('required'),
            'email' => $text('email'),
            'string' => $text('string'),
            'regex' => $text('regex'),
            'max' => $text('max'),
            'privacy.accepted' => $text('privacy_accepted'),
        ];
    }

    private function pageLocale(Request $request): string
    {
        $lang = $request->route('lang');

        return is_string($lang) ? $lang : app()->getLocale();
    }
}
