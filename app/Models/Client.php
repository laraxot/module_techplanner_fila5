<?php

declare(strict_types=1);

namespace Modules\TechPlanner\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
use Modules\Geo\Enums\AddressItemEnum;
use Modules\Geo\Models\Address;
use Modules\Geo\Models\Traits\GeographicalScopes;
use Modules\Geo\Models\Traits\HasAddress;
use Modules\Xot\Models\Traits\HasDynamicFillable;
use Override;
use UnitEnum;

use function Safe\preg_match;
use function Safe\preg_replace;

/**
 * Class Client.
 *
 * @property-read Address|null $address
 * @property-read Collection<int, Address> $addresses
 * @property-read int|null $addresses_count
 * @property-read Collection<int, Appointment> $appointments
 * @property-read int|null $appointments_count
 * @property-read Profile|null $creator
 * @property-read Collection<int, Device> $devices
 * @property-read int|null $devices_count
 * @property-read string $contacts_html
 * @property-read string $full_address
 * @property-read string|null $full_addresses
 * @property-read Collection<int, LegalOffice> $legalOffices
 * @property-read int|null $legal_offices_count
 * @property-read Collection<int, LegalRepresentative> $legalRepresentatives
 * @property-read int|null $legal_representatives_count
 * @property-read Collection<int, MedicalDirector> $medicalDirectors
 * @property-read int|null $medical_directors_count
 * @property-read Collection<int, PhoneCall> $phoneCalls
 * @property-read int|null $phone_calls_count
 * @property-read Profile|null $updater
 *
 * @method static Builder<static>|Client inCity(string $city)
 * @method static Builder<static>|Client inPostalCode(string $postalCode)
 * @method static Builder<static>|Client inProvince(string $province)
 * @method static Builder<static>|Client inRegion(string $region)
 * @method static Builder<static>|Client newModelQuery()
 * @method static Builder<static>|Client newQuery()
 * @method static Builder<static>|Client orderByDistance(float $latitude, float $longitude)
 * @method static Builder<static>|Client query()
 * @method static Builder<static>|Client withDistance(float $latitude, float $longitude)
 *
 * @property int $id
 * @property string|null $vat_number
 * @property string|null $fiscal_code
 * @property string|null $name Location name
 * @property string|null $route Street name (Via/Piazza)
 * @property string|null $street_number Street number
 * @property string|null $locality City/Municipality
 * @property string|null $administrative_area_level_3 Comune
 * @property string|null $administrative_area_level_2 Provincia
 * @property string|null $administrative_area_level_1 Regione
 * @property string|null $country Country/Stato
 * @property string|null $postal_code CAP/Postal Code
 * @property float|null $latitude Latitude coordinate
 * @property float|null $longitude Longitude coordinate
 * @property string|null $notes General notes
 * @property string|null $phone
 * @property string|null $mobile
 * @property string|null $email
 * @property string|null $pec
 * @property string|null $whatsapp
 * @property string|null $city Legacy city field
 * @property string|null $province Legacy province field
 * @property string|null $region Legacy region field
 * @property string|null $cap Legacy CAP field
 * @property bool $business_closed
 * @property string|null $competent_health_unit Az ULSS competente
 * @property string|null $tax_code Codice fiscale
 * @property string|null $company_name Ragione sociale
 * @property string|null $company_office Sede ditta
 * @property string|null $activity Attività
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $updated_by
 * @property string|null $created_by
 * @property string|null $deleted_at
 * @property string|null $deleted_by
 *
 * @method static Builder<static>|Client whereActivity($value)
 * @method static Builder<static>|Client whereAddress($value)
 * @method static Builder<static>|Client whereAdministrativeAreaLevel1($value)
 * @method static Builder<static>|Client whereAdministrativeAreaLevel2($value)
 * @method static Builder<static>|Client whereAdministrativeAreaLevel3($value)
 * @method static Builder<static>|Client whereBusinessClosed($value)
 * @method static Builder<static>|Client whereCap($value)
 * @method static Builder<static>|Client whereCity($value)
 * @method static Builder<static>|Client whereCompanyName($value)
 * @method static Builder<static>|Client whereCompanyOffice($value)
 * @method static Builder<static>|Client whereCompetentHealthUnit($value)
 * @method static Builder<static>|Client whereCountry($value)
 * @method static Builder<static>|Client whereCreatedAt($value)
 * @method static Builder<static>|Client whereCreatedBy($value)
 * @method static Builder<static>|Client whereDeletedAt($value)
 * @method static Builder<static>|Client whereDeletedBy($value)
 * @method static Builder<static>|Client whereFiscalCode($value)
 * @method static Builder<static>|Client whereId($value)
 * @method static Builder<static>|Client whereLatitude($value)
 * @method static Builder<static>|Client whereLocality($value)
 * @method static Builder<static>|Client whereLongitude($value)
 * @method static Builder<static>|Client whereName($value)
 * @method static Builder<static>|Client whereNotes($value)
 * @method static Builder<static>|Client wherePostalCode($value)
 * @method static Builder<static>|Client whereProvince($value)
 * @method static Builder<static>|Client whereRegion($value)
 * @method static Builder<static>|Client whereRoute($value)
 * @method static Builder<static>|Client whereStreetNumber($value)
 * @method static Builder<static>|Client whereTaxCode($value)
 * @method static Builder<static>|Client whereUpdatedAt($value)
 * @method static Builder<static>|Client whereUpdatedBy($value)
 * @method static Builder<static>|Client whereVatNumber($value)
 *
 * @mixin \Eloquent
 */
class Client extends BaseModel
{
    use GeographicalScopes;

    /** @use HasAddress<Client> */
    use HasAddress;

    use HasDynamicFillable;

    /**
     * Define which enums contribute to the dynamic fillable fields.
     *
     * @var array<int, class-string<UnitEnum>>
     */
    protected array $dynamicFillableEnums = [
        AddressItemEnum::class,
    ];

    /**
     * @return array<int, class-string<UnitEnum>>
     */
    protected function getDynamicFillableEnums(): array
    {
        return $this->dynamicFillableEnums;
    }

    protected $fillable = [
        'name',
        'vat_number',
        'fiscal_code',
        // Additional fields from business context
        'business_closed',
        'company_name',
        'competent_health_unit',
        'tax_code',
        'fax',
        'mobile',
        'pec',
        'whatsapp',
        'assigned_worker_id',
        'notes',
        'administrative_reference',
    ];

    public function getFullAddressAttribute(?string $value): string
    {
        if ($value !== null) {
            return (string) $value;
        }
        $address = sprintf(
            '%s, %s - %s, %s (%s)',
            (string) ($this->route ?? ''),
            (string) ($this->street_number ?? ''),
            (string) ($this->postal_code ?? ''),
            (string) ($this->city ?? ''),
            (string) ($this->province ?? ''),
        );

        $replaced = preg_replace('/[,\s]+/', ' ', $address);
        if ($replaced === null || is_array($replaced)) {
            return trim($address);
        }

        return trim($replaced);
    }

    /**
     * Get the devices for the client.
     *
     * @return HasMany<Device, $this>
     */
    public function devices(): HasMany
    {
        return $this->hasMany(Device::class);
    }

    /**
     * Get the appointments for the client.
     *
     * @return HasMany<Appointment, $this>
     */
    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class);
    }

    /**
     * Get the legal offices for the client.
     *
     * @return HasMany<LegalOffice, $this>
     */
    public function legalOffices(): HasMany
    {
        return $this->hasMany(LegalOffice::class);
    }

    /**
     * Get the legal representatives for the client.
     *
     * @return HasMany<LegalRepresentative, $this>
     */
    public function legalRepresentatives(): HasMany
    {
        return $this->hasMany(LegalRepresentative::class);
    }

    /**
     * Get the medical directors for the client.
     *
     * @return HasMany<MedicalDirector, $this>
     */
    public function medicalDirectors(): HasMany
    {
        return $this->hasMany(MedicalDirector::class);
    }

    /**
     * @return HasMany<PhoneCall, $this>
     */
    public function phoneCalls(): HasMany
    {
        return $this->hasMany(PhoneCall::class);
    }

    /**
     * The attributes that should be cast.
     */
    #[Override]
    protected function casts(): array
    {
        return [
            'business_closed' => 'boolean',
            'longitude' => 'float',
            'latitude' => 'float',
        ];
    }

    /**
     * Genera HTML per i contatti con icone e link.
     */
    public function getContactsHtmlAttribute(): string
    {
        $contacts = [];

        if (is_string($this->phone) && $this->phone !== '') {
            $contacts[] = $this->formatContactLink(
                'phone',
                $this->phone,
                'heroicon-o-phone',
                'text-blue-600 hover:text-blue-800',
                'Chiama: '.$this->phone,
            );
        }

        if (is_string($this->mobile) && $this->mobile !== '') {
            $contacts[] = $this->formatContactLink(
                'mobile',
                $this->mobile,
                'heroicon-o-device-phone-mobile',
                'text-blue-500 hover:text-blue-700',
                'Chiama cellulare: '.$this->mobile,
            );
        }

        if (is_string($this->email) && $this->email !== '') {
            $contacts[] = $this->formatContactLink(
                'email',
                $this->email,
                'heroicon-o-envelope',
                'text-green-600 hover:text-green-800',
                'Email: '.$this->email,
            );
        }

        if (is_string($this->pec) && $this->pec !== '') {
            $contacts[] = $this->formatContactLink(
                'pec',
                $this->pec,
                'heroicon-o-shield-check',
                'text-purple-600 hover:text-purple-800',
                'PEC: '.$this->pec,
            );
        }

        if (is_string($this->whatsapp) && $this->whatsapp !== '') {
            $contacts[] = $this->formatContactLink(
                'whatsapp',
                $this->whatsapp,
                'heroicon-o-chat-bubble-left-right',
                'text-green-500 hover:text-green-700',
                'WhatsApp: '.$this->whatsapp,
            );
        }

        if (empty($contacts)) {
            return '<span class="text-gray-400 text-sm italic">Nessun contatto</span>';
        }

        return '<div class="flex flex-wrap gap-2">'.implode('', $contacts).'</div>';
    }

    /**
     * Formatta un singolo link di contatto.
     */
    private function formatContactLink(
        string $type,
        string $value,
        string $icon,
        string $classes,
        string $title,
    ): string {
        $href = $this->getContactHref($type, $value);
        $displayValue = $this->getContactDisplayValue($type, $value);
        $iconSvg = $this->getHeroIcon($icon);

        return sprintf(
            '<a href="%s" class="inline-flex items-center gap-1 %s transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-1 rounded" title="%s" aria-label="%s">%s<span class="text-xs hidden sm:inline">%s</span></a>',
            htmlspecialchars($href, ENT_QUOTES, 'UTF-8'),
            htmlspecialchars($classes, ENT_QUOTES, 'UTF-8'),
            htmlspecialchars($title, ENT_QUOTES, 'UTF-8'),
            htmlspecialchars($title, ENT_QUOTES, 'UTF-8'),
            $iconSvg,
            htmlspecialchars($displayValue, ENT_QUOTES, 'UTF-8'),
        );
    }

    /**
     * Genera l'href appropriato per il tipo di contatto.
     */
    private function getContactHref(string $type, string $value): string
    {
        $phone = preg_replace('/[^+\d]/', '', $value);
        $whatsapp = preg_replace('/[^+\d]/', '', $value);

        $phoneClean = is_string($phone) ? $phone : '';
        $whatsappClean = is_string($whatsapp) ? $whatsapp : '';

        return match ($type) {
            'phone', 'mobile' => 'tel:'.$phoneClean,
            'email', 'pec' => 'mailto:'.$value,
            'whatsapp' => 'https://wa.me/'.$whatsappClean,
            default => '#',
        };
    }

    /**
     * Genera il valore display per il tipo di contatto.
     */
    private function getContactDisplayValue(string $type, string $value): string
    {
        return match ($type) {
            'phone', 'mobile' => $this->formatPhoneNumber($value),
            'email', 'pec' => strlen($value) > 20 ? (substr($value, 0, 17).'...') : $value,
            'whatsapp' => 'WhatsApp',
            default => $value,
        };
    }

    /**
     * Formatta un numero di telefono per la visualizzazione.
     */
    private function formatPhoneNumber(string $phone): string
    {
        // Rimuove tutti i caratteri non numerici eccetto il +
        $clean = preg_replace('/[^+\d]/', '', $phone);
        $clean = is_string($clean) ? $clean : '';

        // Formattazione italiana standard
        if (preg_match('/^\+39(\d{10})$/', $clean, $matches)) {
            $number = $matches[1];
            if (strlen($number) === 10) {
                return '+39 '.substr($number, 0, 3).' '.substr($number, 3, 3).' '.substr($number, 6);
            }
        }

        return $phone;
    }

    /**
     * Genera SVG per icona Heroicon.
     */
    private function getHeroIcon(string $iconName): string
    {
        $icons = [
            'heroicon-o-phone' => '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>',
            'heroicon-o-device-phone-mobile' => '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a1 1 0 001-1V4a1 1 0 00-1-1H8a1 1 0 00-1 1v16a1 1 0 001 1z"></path></svg>',
            'heroicon-o-envelope' => '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>',
            'heroicon-o-shield-check' => '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>',
            'heroicon-o-chat-bubble-left-right' => '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>',
        ];

        return $icons[$iconName] ?? '';
    }
}
