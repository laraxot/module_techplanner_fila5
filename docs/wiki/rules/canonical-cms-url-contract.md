---
title: "Contratto URL canonici nei contenuti CMS"
type: rule
module: TechPlanner
tags: [cms, folio, routes, localization, json, quality]
qmd: "TechPlanner CMS JSON URL route container0.index contacts container0.view localizzazione lingua hardcoded"
---

# Contratto URL canonici nei contenuti CMS

## Perché

Un valore come `/it/contacts` è un URL già renderizzato, non un contratto del
CMS: congela la lingua e bypassa la shell Folio. Il dato deve descrivere la
destinazione semantica; `HasBlocks` compila la route nel contesto della lingua
attiva e il tema riceve un URL coerente.

## Regola

Nei JSON dei blocchi usare esclusivamente espressioni `route(...)` allowlistate:

```json
"url": "{{ route('container0.index',['container0'=>'contacts']) }}"
```

Per un dettaglio:

```json
"url": "{{ route('container0.view',['container0'=>'services','slug0'=>'radioprotezione']) }}"
```

Vietati nei link interni CMS: `/it/...`, `/en/...`, `url('/...')`,
`LaravelLocalization::localizeUrl(...)` e nomi di rotta inventati dal titolo
della pagina. `tel:` e `mailto:` restano URI esterni e non vanno trasformati.

## Protezione dalla regressione

Il test `CanonicalCmsUrlsTest` verifica tutti i JSON del modulo e del tenant:

- nessun URL web interno contiene un prefisso locale scritto a mano;
- il CTA contatti contiene il contratto `container0.index` canonico;
- i JSON restano validi.

La stessa regola vale per gli URL inseriti dentro HTML nei campi `content` e
per i fallback del tema: non basta controllare solo le chiavi JSON chiamate
`url` o `href`. La guardia owner scansiona ogni stringa dei contenuti e il
footer del tema costruisce i link legali con `route('container0.index', ...)`.

Quando si aggiunge un nuovo blocco, eseguire il test owner e verificare il nome
con `php artisan folio:list`. Il valore `container0`/`slug0` è parametro della
shell, non parte del nome di una pagina o di un modulo.
