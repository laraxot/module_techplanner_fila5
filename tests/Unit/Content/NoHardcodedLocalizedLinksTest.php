<?php

declare(strict_types=1);

use Modules\TechPlanner\Tests\TestCase;
use PHPUnit\Framework\Assert;
use Symfony\Component\Finder\Finder;

use function Safe\file_get_contents;
use function Safe\json_decode;
use function Safe\preg_match;

uses(TestCase::class);

/**
 * @return list<string>
 */
function techPlannerContentJsonFiles(): array
{
    $finder = Finder::create()
        ->files()
        ->in([
            base_path('config/local/techplanner/database/content'),
            base_path('Modules/TechPlanner/config/database/content'),
        ])
        ->name('*.json');

    $files = [];
    foreach ($finder as $file) {
        $files[] = $file->getPathname();
    }

    sort($files);

    return $files;
}

/**
 * @param  array<array-key, mixed>  $value
 * @param  list<string>  $violations
 */
function collectHardcodedLocalizedLinks(array $value, string $path, array &$violations): void
{
    foreach ($value as $key => $item) {
        $itemPath = $path.'.'.(string) $key;
        if (is_string($item)
            && preg_match("#(?:^|[\"'])/(it|en|de|es)(?:/|$)#", $item) === 1) {
            $violations[] = $itemPath.'='.$item;
        }

        if (is_array($item)) {
            collectHardcodedLocalizedLinks($item, $itemPath, $violations);
        }
    }
}

test('CMS content does not hardcode locale prefixes in public links', function (): void {
    $violations = [];

    foreach (techPlannerContentJsonFiles() as $file) {
        $decoded = json_decode(file_get_contents($file), true);
        Assert::assertIsArray($decoded, $file);
        collectHardcodedLocalizedLinks($decoded, $file, $violations);
    }

    Assert::assertSame([], $violations, implode(PHP_EOL, $violations));
});

test('Theme Two uses the named Folio index route for CMS indexes', function (): void {
    $finder = Finder::create()
        ->files()
        ->in(base_path('Themes/Two/resources/views'))
        ->name('*.blade.php');

    $violations = [];
    foreach ($finder as $file) {
        $contents = file_get_contents($file->getPathname());
        if (str_contains($contents, "route('container0',")) {
            $violations[] = $file->getPathname();
        }
    }

    Assert::assertSame([], $violations, implode(PHP_EOL, $violations));
});
