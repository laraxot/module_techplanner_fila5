<?php

declare(strict_types=1);

namespace Modules\TechPlanner\Tests\Unit\Content;

use Illuminate\Support\Str;
use Modules\Gdpr\Actions\Cookie\GetCookieInventoryAction;
use Modules\TechPlanner\Tests\TestCase;
use PHPUnit\Framework\Assert;

use function Safe\file_get_contents;
use function Safe\json_decode;
use function Safe\preg_match;

uses(TestCase::class);

/*
 * Le pagine legali del sito non possono dire una cosa diversa da quella che il server fa.
 *
 * La fonte tecnica e' il modulo Gdpr: `GetCookieInventoryAction` ricava i cookie dalla configurazione reale (nome e durata
 * della sessione, chiave del consenso, cookie «Ricordami») e dai cookie non tecnici dichiarati in `gdpr.config.cookie.extra`.
 * La cookie policy del sito e' testo editoriale nei JSON dei contenuti: qui si controlla che nomini ogni cookie
 * dell'inventario con la sua durata e che, finche' non esistono cookie non tecnici, nessuna pagina legale nomini un servizio
 * di tracciamento (e' il difetto trovato nel re-audit: Google Analytics e AdSense dichiarati senza che il sito li carichi).
 * Test puro sui file: nessun database.
 */

/**
 * @return array<string, string> lingua => testo HTML dei blocchi `content` della pagina legale
 */
function techplannerLegalPageText(string $slug): array
{
    $file = dirname(__DIR__, 5).'/Modules/TechPlanner/config/database/content/pages/'.$slug.'.json';
    $decoded = json_decode(file_get_contents($file), true);
    $byLocale = is_array($decoded) && is_array($decoded['content_blocks'] ?? null) ? $decoded['content_blocks'] : [];

    $texts = [];
    foreach ($byLocale as $locale => $blocks) {
        $texts[(string) $locale] = '';
        foreach (is_array($blocks) ? $blocks : [] as $block) {
            $content = is_array($block) && is_array($block['data'] ?? null) ? ($block['data']['content'] ?? null) : null;
            $texts[(string) $locale] .= is_string($content) ? ' '.$content : '';
        }
    }

    return $texts;
}

test('la cookie policy nomina ogni cookie dell inventario con la sua durata', function (): void {
    app()->setLocale('it');
    $inventory = app(GetCookieInventoryAction::class)->execute();
    $texts = techplannerLegalPageText('cookies');

    $missing = [];
    foreach (['it', 'en'] as $locale) {
        $text = $texts[$locale] ?? '';
        foreach ($inventory->cookies as $cookie) {
            // Il cookie «Ricordami» ha un suffisso con l'hash della classe: la pagina riporta solo il prefisso.
            $name = str_starts_with($cookie->name, 'remember_') ? Str::beforeLast($cookie->name, '_').'_' : $cookie->name;
            if (! str_contains($text, $name)) {
                $missing[] = $locale.': cookie '.$name;
            }

            preg_match('/(\d+)\s*(minut|giorn)/u', $cookie->duration, $found);
            if (! isset($found[1], $found[2])) {
                continue;
            }
            $amount = (int) $found[1];
            $isDays = $found[2] === 'giorn';
            if (! $isDays && $amount % 60 === 0) {
                $amount = intdiv($amount, 60);
                $unit = $locale === 'it' ? 'ore' : 'hours';
            } else {
                $unit = $isDays ? ($locale === 'it' ? 'giorni' : 'days') : ($locale === 'it' ? 'minuti' : 'minutes');
            }
            if (preg_match('/\b'.$amount.'\s+'.$unit.'\b/u', $text) !== 1) {
                $missing[] = $locale.': durata '.$amount.' '.$unit.' ('.$cookie->name.')';
            }
        }
    }

    Assert::assertSame([], $missing, "La cookie policy non riporta cio' che il server imposta:\n".implode("\n", $missing));
});

test('senza cookie non tecnici dichiarati nessuna pagina legale nomina servizi di tracciamento', function (): void {
    app()->setLocale('it');
    if (app(GetCookieInventoryAction::class)->execute()->requiresConsent()) {
        $this->markTestSkipped('Esistono cookie non tecnici dichiarati: il test sopra ne verifica i nomi.');
    }

    $forbidden = ['google analytics', 'adsense', 'google tag manager', 'doubleclick', 'facebook pixel', 'hotjar', 'matomo', 'clarity', '<iframe'];
    $found = [];
    foreach (['cookie', 'cookies', 'privacy', 'terms'] as $slug) {
        foreach (techplannerLegalPageText($slug) as $locale => $text) {
            foreach ($forbidden as $term) {
                if (str_contains(mb_strtolower($text), $term)) {
                    $found[] = $slug.' ('.$locale.'): '.$term;
                }
            }
        }
    }

    Assert::assertSame([], $found, "Pagine legali che nominano servizi che il sito non carica:\n".implode("\n", $found));
});

test('il login non afferma certificazioni ne conformita non dimostrate', function (): void {
    $login = file_get_contents(dirname(__DIR__, 5).'/Themes/Two/resources/views/pages/auth/login.blade.php');

    Assert::assertSame(0, preg_match('/ISO\s*9001|quality_certification|regulatory_compliance/i', $login));
});
