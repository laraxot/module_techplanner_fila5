<?php

declare(strict_types=1);

namespace Modules\TechPlanner\Tests\Unit\Models;

use Modules\TechPlanner\Models\Client;
use Modules\TechPlanner\Tests\TestCase;

uses(TestCase::class);

it('builds a clean full address when route already contains the details', function () {
    $client = new Client();
    $client->setRawAttributes([
        'route' => 'P.za Ruzante, 12, 35020 Codevigo PD',
        'street_number' => '12',
        'postal_code' => '35020',
        'city' => null,
        'province' => null,
    ]);

    expect($client->full_address)->toBe('P.za Ruzante 12 35020 Codevigo PD');
});

it('appends address fields missing from route', function () {
    $client = new Client();
    $client->setRawAttributes([
        'route' => 'Via Roma',
        'street_number' => '1',
        'postal_code' => '20100',
        'city' => 'Milano',
        'province' => 'MI',
    ]);

    expect($client->full_address)->toBe('Via Roma 1 20100 Milano MI');
});

it('returns the stored full address untouched when present', function () {
    $client = new Client();
    $client->setRawAttributes(['full_address' => 'Custom Address 42']);

    expect($client->full_address)->toBe('Custom Address 42');
});
