---
title: "Niente testi fissi nelle Blade del modulo TechPlanner (multilingua it/en/de/es)"
type: story
status: implemented
module: TechPlanner
updated: 2026-10-30
tags: [i18n, blade, multilingua]
---

# Niente testi fissi nelle Blade del modulo TechPlanner

## Scopo

Il sito risponde in italiano, inglese, tedesco e spagnolo: un testo scritto dentro una Blade esce uguale in ogni lingua. Il `fallback_locale` e' `it`, quindi una chiave mancante in `en`/`de`/`es` non da' errore e mostra l'italiano.

## Regola operativa

- Ogni testo visibile passa da `{{ __('techplanner::contesto.collezione.chiave.tipo') }}`: cinque elementi, dove `contesto` e' il nome del file lingua e `tipo` il genere di testo (`label`, `title`, `description`, `placeholder`, `tooltip`, `helper_text`, `message`, `aria_label`, `alt`; [regola 008](../../../../../docs/wiki/rules/008-translation-5-level-protocol.md)). Mai la frase come chiave: nessun file la traduce, e il traduttore ignora `['default' => ...]`.
- La stringa va in `Modules/TechPlanner/lang/{it,en,de,es}/<contesto>.php`, con le stesse chiavi e gli stessi `:parametri` nelle quattro lingue. `it` e' l'originale; `en`, `de`, `es` sono traduzioni vere.
- Vale anche per `aria-label`, `placeholder`, `title`, `alt` e, in PHP, per `->label()`, `->placeholder()`, `->tooltip()`, `->helperText()`.
- Frasi con variabili: segnaposto `:param` e `trans_choice` per i plurali; il markup resta nella Blade e la frase si spezza solo dove serve.
- Link a pagine CMS: niente `href="/it/..."`, niente `url('/...')`, niente nomi di rotta inventati per pagina. Si usa la rotta generica della shell Folio, `route('container0.view', ['container0' => 'area-personale', 'slug0' => 'notifiche'])`: il prefisso lingua lo aggiunge Folio. L'indice ha un nome diverso per tema (`container0` in Two e Meetup, `container0.index` in Sixteen e TwentyOne): una vista di modulo condivisa tra temi usa `view` oppure riceve l'URL dal chiamante. I nomi Folio veri (`home`, `login`, `logout`) restano validi.
- Non sono errori: marchi e nomi propri, sigle, numeri, valori che arrivano dal modello.

## Cosa e' stato fatto

- Rilevatore `bashscripts/tools/i18n/find-hardcoded-blade-text.py` sul modulo: da 27 occorrenze in 7 file a 6 in 4 file (stesso strumento, commit di partenza contro stato attuale).
- 3 Blade convertite: home del modulo e widget delle coordinate (due copie della vista).
- Nuove collezioni in `it`, `en`, `de`, `es`: `home` e `coordinates_widget` (16 chiavi per lingua in totale); `client` solo in `es`.
- Completate le chiavi preesistenti usate dalle Blade: 16 in `de`, 18 in `es`.
- Controllo statico sulle 68 Blade di User, Employee e TechPlanner: 311 chiavi usate, nessuna mancante in `it`, `en`, `de`, `es`.

## Residui dichiarati (6 occorrenze)

| Categoria | N |
|---|---:|
| Scaffold nWidart non instradato (indice e layout master, in due alberi di viste) | 6 |

Testi in PHP non toccati: circa 10 chiamate `->label()`, `->placeholder()`, `->tooltip()` con testo fisso (conteggio euristico).

## Limiti

- Nessuna verifica a video: chiavi e compilazione sono controllate in modo statico.
- Una parte delle chiavi usate dalle Blade (circa 9 usi) e' nata con quattro elementi invece di cinque: funziona in tutte le lingue ma non e' stata rinominata.
- Verifica del 2026-10-30: PHPStan sui moduli senza errori, compilazione Blade dei file convertiti senza errori, nessuna chiave usata dalla campagna manca in `it`, `en`, `de`, `es`.

## Riferimenti

Metodo e regola completa: [story del tema Two](../../../../Themes/Two/docs/stories/blade-i18n-no-hardcoded-text.story.md); protocollo a cinque elementi: [regola 008](../../../../../docs/wiki/rules/008-translation-5-level-protocol.md). Il dettaglio per file e' nel repo privato di audit.

## Seguito: forma delle chiavi

Le chiavi a 2-3 segmenti create da questa campagna sono state in parte portate a `ns::file.collezione.chiave.tipo`: **7 chiavi spostate** in questo proprietario (stesso testo, tutte le lingue, usi riscritti, nessun uso della vecchia chiave rimasto). La frase sui «tre o quattro elementi» qui sopra descrive lo stato precedente: le chiavi rimaste a 3-4 elementi non sono state verificate una per una; la misura assoluta, lo strumento e i residui sono in [la story di Lang](../../../Lang/docs/stories/translation-key-shape-rekey.story.md).

### Passata 2026-10-30 (sessione 97f16a39, i18n-small-modules: TechPlanner)

Scanner `Modules/TechPlanner`: prima 11 occorrenze in 5 file (6 text, 5 route-unknown), dopo 11 in 5 file (invariato). Le 5 `route-unknown` (`route('techplanner.projects')`, `.contacts`, `.dashboard` in `home.blade.php`) sono residui con decisione dell'utente e non sono state toccate.

- Nessuna modifica. `check-blade-keys` su `Modules/TechPlanner`: 22 usi, 0 mancanti in `it`, `en`, `de`, `es`; compilazione 7 file OK.
- Residui (6): stub `index` e `layouts/master` in due alberi (`resources/views` e `resources/Resources/views`), non instradati (`routes/web.php` senza rotte: le pagine sono Folio). Nessuna classe richiama `techplanner::home` o `techplanner::index`.
- Non verificato: nessuna pagina guardata.
