<?php

declare(strict_types=1);

use PHPUnit\Framework\Assert;
use Symfony\Component\Finder\Finder;

use function Safe\file_get_contents;
use function Safe\json_decode;
use function Safe\preg_match;

/*
 * Contratto JSON <-> vista dei blocchi CMS del sito.
 *
 * Una chiave di `data` che la vista del tema non legge sparisce senza errori: il blocco si vede svuotato (griglia senza
 * schede, banner senza testo ne' pulsante). E' gia' successo con `cta.simple`, `why-critical.grid` e `cta.banner`.
 * Qui si verifica che ogni chiave di primo livello compaia nella vista (`$chiave` o `'chiave'`).
 *
 * Il debito che c'e' oggi e' elencato per nome: un difetto nuovo fa fallire il primo test, un debito sanato fa fallire
 * il secondo finche' non si toglie dall'elenco. Test puro: legge solo file, non usa ne' l'applicazione ne' il database.
 */

/**
 * @return list<string> `file|vista|chiave`, senza doppioni e ordinati
 */
function techplannerBlockContractFindings(): array
{
    $laravel = dirname(__DIR__, 5);
    $content = $laravel.'/Modules/TechPlanner/config/database/content';
    $themePrefix = 'pub_theme::';
    $viewsDir = $laravel.'/Themes/Two/resources/views';

    $findings = [];
    foreach (Finder::create()->files()->in([$content.'/pages', $content.'/sections'])->name('*.json') as $file) {
        $decoded = json_decode(file_get_contents($file->getPathname()), true);
        if (! is_array($decoded)) {
            continue;
        }

        foreach (['content_blocks', 'sidebar_blocks', 'footer_blocks', 'blocks'] as $area) {
            $byLocale = $decoded[$area] ?? null;
            foreach (is_array($byLocale) ? $byLocale : [] as $blocks) {
                foreach (is_array($blocks) ? $blocks : [] as $block) {
                    $data = is_array($block) ? ($block['data'] ?? null) : null;
                    $view = is_array($data) ? ($data['view'] ?? null) : null;
                    if (! is_array($data) || ! is_string($view) || ! str_starts_with($view, $themePrefix)) {
                        continue;
                    }

                    $relative = substr($file->getPathname(), strlen($content) + 1);
                    $viewFile = $viewsDir.'/'.str_replace('.', '/', substr($view, strlen($themePrefix))).'.blade.php';
                    if (! is_file($viewFile)) {
                        $findings[] = $relative.'|'.$view.'|(vista inesistente)';

                        continue;
                    }

                    $source = file_get_contents($viewFile);
                    foreach (array_keys($data) as $key) {
                        $name = (string) $key;
                        if ('view' === $name || 1 === preg_match('/\$'.preg_quote($name, '/').'\b|[\'"]'.preg_quote($name, '/').'[\'"]/', $source)) {
                            continue;
                        }
                        $findings[] = $relative.'|'.$view.'|'.$name;
                    }
                }
            }
        }
    }

    $findings = array_values(array_unique($findings));
    sort($findings);

    return $findings;
}

/**
 * Debito noto, da ridurre: ogni voce e' una chiave che la vista ignora oggi.
 *
 * @return list<string>
 */
function techplannerBlockContractKnownDebt(): array
{
    return [
        // Da rinominare nel JSON in `description` / `backgroundColor`: il file e' in lavorazione in un'altra sessione.
        'pages/chi-siamo.json|pub_theme::components.blocks.features.grid|subtitle',
        'pages/chi-siamo.json|pub_theme::components.blocks.stats.overview|background_color',
        'pages/chi-siamo.json|pub_theme::components.blocks.stats.overview|subtitle',
        // Ancore `id` che la vista non emette e a cui nulla punta; `intro` coincide con il testo predefinito.
        'pages/faqs.json|pub_theme::components.blocks.hero.faq|id',
        'pages/home.json|pub_theme::components.blocks.what-we-do.checklist|intro',
        'pages/home.json|pub_theme::components.blocks.why-critical.grid|id',
        // Titolo che la vista non mostra (mostra solo il contenuto).
        'pages/profile.json|pub_theme::components.blocks.content.simple|title',
        // Dati del footer senza vista che li mostri (certificazioni, mappa, testimonianze).
        'sections/footer.json|pub_theme::components.sections.footer.v1|certifications',
        'sections/footer.json|pub_theme::components.sections.footer.v1|map',
    ];
}

test('ogni chiave di un blocco e letta dalla sua vista, salvo il debito noto', function (): void {
    $unexpected = array_values(array_diff(techplannerBlockContractFindings(), techplannerBlockContractKnownDebt()));

    Assert::assertSame([], $unexpected, "Chiavi del JSON che la vista ignora (rinominare la chiave nel JSON, non aggiungere debito):\n".implode("\n", $unexpected));
});

test('il debito noto elenca solo difetti che esistono ancora', function (): void {
    $fixed = array_values(array_diff(techplannerBlockContractKnownDebt(), techplannerBlockContractFindings()));

    Assert::assertSame([], $fixed, "Difetti sanati da togliere dall'elenco del debito:\n".implode("\n", $fixed));
});

test('le copie dei contenuti nel tenant e nel modulo sono identiche', function (): void {
    $laravel = dirname(__DIR__, 5);
    $moduleContent = $laravel.'/Modules/TechPlanner/config/database/content';
    $tenantContent = $laravel.'/config/local/techplanner/database/content';

    $different = [];
    foreach (Finder::create()->files()->in([$moduleContent.'/pages', $moduleContent.'/sections'])->name('*.json') as $file) {
        $relative = substr($file->getPathname(), strlen($moduleContent) + 1);
        $copy = $tenantContent.'/'.$relative;
        if (! is_file($copy) || file_get_contents($copy) !== file_get_contents($file->getPathname())) {
            $different[] = $relative;
        }
    }
    sort($different);

    Assert::assertSame([], $different, "Copie tenant e modulo diverse o mancanti:\n".implode("\n", $different));
});
