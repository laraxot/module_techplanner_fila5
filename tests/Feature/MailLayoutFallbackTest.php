<?php

declare(strict_types=1);

use Modules\Notify\Filament\Forms\Components\HtmlLayoutPathSelect;
use Modules\TechPlanner\Tests\TestCase;
use Modules\Xot\Datas\XotData;

uses(TestCase::class);

// XotData è un singleton: il tema cambiato qui non deve restare ai test successivi.
beforeEach(function (): void {
    $this->previousPubTheme = XotData::make()->pub_theme;
});

afterEach(function (): void {
    XotData::make()->pub_theme = $this->previousPubTheme;
});

/*
 * Un tema senza `resources/mail-layouts` (era il caso di Two fino al 2026-11-06; qui un tema fittizio): l'invio delle
 * e-mail da modello leggeva un file inesistente e «Nuovo modello e-mail» andava in errore 500. Ora si usa
 * il layout di Notify.
 */
it('finds a mail layout for a theme that has none', function (): void {
    expect(base_path('Themes/SenzaLayout/resources/mail-layouts'))->not->toBeDirectory();
    $xot = XotData::make();
    $xot->pub_theme = 'SenzaLayout';

    expect($xot->getMailHtmlLayoutPath('base.html'))->toBeFile()
        ->and($xot->getMailHtmlLayoutPath())->toBeDirectory();
});

it('lists the available layouts in the mail template form', function (): void {
    XotData::make()->pub_theme = 'Two';

    expect(HtmlLayoutPathSelect::make()->getOptions())->toHaveKey('base.html');
});
