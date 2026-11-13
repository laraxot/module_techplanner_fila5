<?php

declare(strict_types=1);

/*
 * Dati di esempio per gli screenshot del manuale d'uso. Solo DB SQLite locale di prova.
 * Nomi di clienti e persone inventati; coordinate = centri dei comuni.
 */

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Modules\TechPlanner\Models\Appointment;
use Modules\TechPlanner\Models\Client;
use Modules\TechPlanner\Models\Device;
use Modules\TechPlanner\Models\DeviceVerification;
use Modules\TechPlanner\Models\MedicalDirector;
use Modules\TechPlanner\Models\PhoneCall;
use Modules\User\Models\Role;
use Modules\User\Models\User;

Model::unguard();

$plain = getenv('MANUAL_DEMO_PASSWORD') ?: throw new RuntimeException('Imposta MANUAL_DEMO_PASSWORD');
$password = Hash::make($plain);
$roles = [];
foreach (['super-admin', 'techplanner::admin', 'techplanner::operator', 'user::admin'] as $name) {
    $roles[$name] = Role::query()->firstOrCreate(['name' => $name, 'guard_name' => 'web']);
}

$users = [
    ['email' => 'admin@example.com', 'first_name' => 'Anna', 'last_name' => 'Amministratrice', 'type' => 'master_admin', 'roles' => ['super-admin']],
    ['email' => 'segreteria@example.com', 'first_name' => 'Giulia', 'last_name' => 'Segreteria', 'type' => 'backoffice_user', 'roles' => ['techplanner::operator']],
    ['email' => 'tecnico@example.com', 'first_name' => 'Paolo', 'last_name' => 'Tecnico', 'type' => 'technician', 'roles' => ['techplanner::operator']],
    ['email' => 'utenti@example.com', 'first_name' => 'Sara', 'last_name' => 'Gestione Utenti', 'type' => 'backoffice_user', 'roles' => ['user::admin']],
    ['email' => 'cliente@example.com', 'first_name' => 'Marta', 'last_name' => 'Cliente', 'type' => 'customer_user', 'roles' => []],
];
foreach ($users as $u) {
    $user = User::query()->updateOrCreate(['email' => $u['email']], [
        'name' => $u['first_name'].' '.$u['last_name'],
        'first_name' => $u['first_name'],
        'last_name' => $u['last_name'],
        'password' => $password,
        'type' => $u['type'],
        'is_active' => true,
        'email_verified_at' => now(),
        'lang' => 'it',
    ]);
    $user->syncRoles($u['roles']);
}

$clients = [
    ['Studio Dentistico Bianchi', 'Studio dentistico', 'Via Piave', '12', '30171', 'Venezia', 'VE', 45.4904, 12.2389, 'AULSS 3 Serenissima'],
    ['Poliambulatorio San Marco', 'Poliambulatorio', 'Viale Garibaldi', '45', '30173', 'Venezia', 'VE', 45.4892, 12.2541, 'AULSS 3 Serenissima'],
    ['Studio Odontoiatrico Verdi', 'Studio dentistico', 'Piazza dei Signori', '3', '31100', 'Treviso', 'TV', 45.6669, 12.2430, 'AULSS 2 Marca Trevigiana'],
    ['Centro Medico Riviera', 'Poliambulatorio', 'Via Roma', '88', '35027', 'Noventa Padovana', 'PD', 45.4170, 11.9470, 'AULSS 6 Euganea'],
    ['Clinica Dentale Colombo', 'Studio dentistico', 'Corso Milano', '20', '35139', 'Padova', 'PD', 45.4064, 11.8768, 'AULSS 6 Euganea'],
    ['Studio Veterinario Ferri', 'Studio veterinario', 'Via Terraglio', '150', '31021', 'Mogliano Veneto', 'TV', 45.5617, 12.2365, 'AULSS 2 Marca Trevigiana'],
    ['Ambulatorio Lido Sorriso', 'Studio dentistico', 'Via Bafile', '201', '30016', 'Jesolo', 'VE', 45.5089, 12.6464, 'AULSS 4 Veneto Orientale'],
    ['Studio Rossi & Associati', 'Studio dentistico', 'Via dei Mille', '7', '31033', 'Castelfranco Veneto', 'TV', null, null, 'AULSS 2 Marca Trevigiana'],
];

$today = Carbon::today();
$types = ['Endorale', 'Panoramico', 'Telecomandato', 'Endorale'];
foreach ($clients as $i => [$name, $activity, $route, $num, $cap, $city, $prov, $lat, $lng, $asl]) {
    $slug = strtolower(preg_replace('/[^a-z]+/i', '', explode(' ', $name)[2] ?? $name) ?: 'studio');
    $client = Client::query()->create([
        'company_name' => $name,
        'name' => $name,
        'activity' => $activity,
        'route' => $route,
        'address' => $route,
        'street_number' => $num,
        'postal_code' => $cap,
        'cap' => $cap,
        'locality' => $city,
        'city' => $city,
        'province' => $prov,
        'administrative_area_level_2' => $prov,
        'country' => 'Italia',
        'formatted_address' => "{$route} {$num}, {$cap} {$city} {$prov}",
        'latitude' => $lat,
        'longitude' => $lng,
        'phone' => '041 555 01'.str_pad((string) ($i + 10), 2, '0'),
        'mobile' => '333 000 00'.str_pad((string) ($i + 10), 2, '0'),
        'email' => "info@{$slug}.example.com",
        'pec' => "{$slug}@pec.example.com",
        'vat_number' => '0'.str_pad((string) (1234567890 + $i * 1111), 10, '0', STR_PAD_LEFT),
        'competent_health_unit' => $asl,
        'business_closed' => false,
        'notes' => $i === 0 ? 'Ingresso dal cortile interno. Chiedere della dott.ssa Bianchi.' : null,
    ]);

    MedicalDirector::query()->create([
        'client_id' => $client->getKey(),
        'name' => ['Dott. Luca Bianchi', 'Dott.ssa Elena Neri', 'Dott. Marco Verdi', 'Dott.ssa Chiara Galli', 'Dott. Andrea Colombo', 'Dott.ssa Sofia Ferri', 'Dott. Davide Russo', 'Dott.ssa Laura Rossi'][$i],
        'phone' => '041 555 02'.str_pad((string) ($i + 10), 2, '0'),
        'email' => "direzione@{$slug}.example.com",
    ]);

    $devicesCount = $i % 3 === 0 ? 2 : 1;
    for ($d = 0; $d < $devicesCount; $d++) {
        $device = Device::query()->create([
            'client_id' => $client->getKey(),
            'name' => $types[($i + $d) % 4].' '.($d + 1),
            'type' => $types[($i + $d) % 4],
            'brand' => ['Carestream', 'Planmeca', 'Vatech', 'Durr Dental'][($i + $d) % 4],
            'model' => ['CS 2200', 'ProX', 'PaX-i', 'VistaIntra'][($i + $d) % 4],
            'headset_serial' => 'CU-'.(24000 + $i * 10 + $d),
            'tube_serial' => 'TB-'.(81000 + $i * 10 + $d),
            'kv' => [60, 70, 85, 65][($i + $d) % 4],
            'ma' => [7, 8, 10, 6][($i + $d) % 4],
            'first_verification_date' => $today->copy()->subYears(4)->subMonths($i),
        ]);

        // Scadenze diverse: alcune già passate, alcune entro 30 giorni, altre lontane.
        $offsets = [-40, 12, 200, -5, 25, 300, 90, -120];
        $next = $today->copy()->addDays($offsets[$i] + $d * 30);
        DeviceVerification::query()->create([
            'device_id' => $device->getKey(),
            'verification_date' => $next->copy()->subYears(2),
            'next_verification_date' => $next,
            'verification_type' => 'Periodica biennale',
            'result' => 'Conforme',
            'exposure_parameters' => '60 kV, 7 mA, 0,2 s',
            'notes' => null,
        ]);
    }

    if ($i < 5) {
        PhoneCall::query()->create([
            'client_id' => $client->getKey(),
            'date' => $today->copy()->subDays(6 - $i)->setTime(9 + $i, 30),
            'duration' => 120 + $i * 45,
            'call_type' => $i === 4 ? 'inbound' : 'outbound',
            'notes' => ['Fissata la visita per la verifica biennale.', 'Richiamare lunedì mattina, il titolare è in ferie.', 'Visita confermata, portare il dosimetro.', 'Nessuna risposta, lasciato messaggio in segreteria.', 'Chiede preventivo per un secondo apparecchio.'][$i],
        ]);
    }

    if (in_array($i, [0, 2, 4, 6], true)) {
        Appointment::query()->create([
            'client_id' => $client->getKey(),
            'date' => $today->copy()->addDays([1, 1, 3, 8][[0 => 0, 2 => 1, 4 => 2, 6 => 3][$i]])->setTime([9, 14, 10, 11][[0 => 0, 2 => 1, 4 => 2, 6 => 3][$i]], 0),
            'notes' => ['Verifica biennale endorale + panoramico. Referente: dott.ssa Bianchi.', 'Verifica periodica. Parcheggio in piazza.', 'Prima verifica dopo il cambio tubo.', 'Verifica periodica, accesso dal retro.'][[0 => 0, 2 => 1, 4 => 2, 6 => 3][$i]],
        ]);
    }
}

echo 'Utenti: '.User::query()->count().', clienti: '.Client::query()->count().', apparecchi: '.Device::query()->count().', verifiche: '.DeviceVerification::query()->count().PHP_EOL;

// Un cliente nel cestino, per mostrare «Record eliminati» e «Ripristina».
$closed = Client::query()->firstOrCreate(['company_name' => 'Studio Chiuso per Errore'], ['activity' => 'Studio dentistico', 'city' => 'Mestre', 'province' => 'VE']);
if (! $closed->trashed()) {
    $closed->delete();
}

// Un appuntamento oggi, per il riquadro «Il giro di oggi» della pagina iniziale.
Appointment::query()->firstOrCreate(
    ['client_id' => Client::query()->where('company_name', 'Studio Dentistico Bianchi')->value('id'), 'date' => today()->setTime(9, 30)],
    ['notes' => 'Verifica periodica endorale, chiedere della dott.ssa Neri'],
);
