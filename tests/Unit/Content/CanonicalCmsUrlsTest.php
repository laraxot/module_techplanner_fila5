<?php

declare(strict_types=1);

use Modules\TechPlanner\Tests\TestCase;
use PHPUnit\Framework\Assert;
use Symfony\Component\Finder\Finder;

use function Safe\file_get_contents;
use function Safe\json_decode;

uses(TestCase::class);

/**
 * Il contenuto CMS deve conservare il contratto di destinazione, non un URL già
 * renderizzato: la lingua viene applicata dalla rotta Folio al momento del render.
 */
test('i CTA contatti usano il contratto canonico container0.index', function (): void {
    $expected = "{{ route('container0.index',['container0'=>'contacts']) }}";
    $files = [
        base_path('Modules/TechPlanner/config/database/content/pages/home.json'),
        base_path('config/local/techplanner/database/content/pages/home.json'),
    ];

    foreach ($files as $file) {
        $content = file_get_contents($file);
        Assert::assertStringContainsString($expected, $content, $file);
    }
});

test('i JSON CMS del modulo e del tenant restano validi', function (): void {
    $finder = Finder::create()
        ->files()
        ->in([
            base_path('Modules/TechPlanner/config/database/content'),
            base_path('config/local/techplanner/database/content'),
        ])
        ->name('*.json');

    foreach ($finder as $file) {
        $decoded = json_decode(file_get_contents($file->getPathname()), true);
        Assert::assertIsArray($decoded, $file->getPathname());
    }
});
