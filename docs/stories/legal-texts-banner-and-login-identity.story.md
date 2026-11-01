---
title: "Testi legali, banner cookie e identita' del login: allineati a cio' che il sito fa"
type: story
module: TechPlanner
theme: Two
status: superseded
priority: high
created: 2026-11-01
updated: 2026-11-01
tags: [gdpr, cookie, privacy, login, logo, claims, bmad]
qmd: "cookie policy banner privacy terms inventario cookie fonte di verita gdpr login iso 9001 logo claim conformita da confermare"
related:
  - ./privacy-gdpr-remediation.story.md
  - ../../../Gdpr/docs/stories/12.1.gdpr-owns-legal-pages.story.md
  - ../../../Gdpr/docs/stories/dcp-136-cookie-inventario-informazione-e-guardia-sui-cookie-impostati.story.md
  - ../../../../Themes/Two/docs/stories/blocks-json-contract-and-share.story.md
---

# Testi legali, banner cookie e identita' del login

> Superata: claim, esito e Dev Agent Record stanno nella sezione «C1» di `./privacy-gdpr-remediation.story.md` (story unica del consolidamento). Questo file resta solo per le tabelle di misura "Fonte di verita'" e "Cosa risulta"; i file ora di f9 non vanno piu' scritti da qui.

## Claim

Sessione C1 del 2026-11-01: confronto tra banner, pagine legali e comportamento reale del sito, tessere del login e logo. Sessione lavora solo sui file elencati in "Owned File/Module Scope". Le pagine legali JSON sono state bloccate a meta' lavoro da un'altra sessione (attivita' `gdpr-legal`, che le sta riscrivendo): da quel momento non le ho piu' toccate (vedi "Ripartenza").

## Fonte di verita'

| Cosa | Chi la possiede | Dove |
|---|---|---|
| Quali cookie il server imposta, nomi e durate | modulo Gdpr (derivati dalla configurazione reale) | `Gdpr/app/Actions/Cookie/GetCookieInventoryAction.php`; cookie non tecnici solo in `gdpr.config.cookie.extra` (oggi vuoto) |
| Testo del banner e modalita' (solo informativa / con consenso) | modulo Gdpr | `Gdpr/lang/cookie-consent/{it,en,de,es}/texts.php`; la modalita' la decide l'inventario, non un flag |
| Testo di cookie policy, privacy, termini | **il sito** (contenuto editoriale) | JSON in `TechPlanner/config/database/content/pages/` e copia tenant `config/local/techplanner/database/content/pages/` (la copia tenant e' quella letta a runtime: `SushiToJsons` -> `GetTenantFilePathAction`; le due copie devono essere identiche, lo verifica `PageBlockContractTest`) |

La story Gdpr 12.1 ("Gdpr possiede Privacy/Terms") e' una bozza `ready-for-dev` che dice "non implementare ora": il modulo Gdpr non ha viste ne' rotte per pagine legali (inventario: nessuna classe HTTP). Quindi la divergenza non e' nel banner (che e' corretto) ma nel testo editoriale dei JSON, scritto una volta e mai riallineato.

## Cosa risulta (misurato)

| Fatto | Prima | Dopo |
|---|---|---|
| Cookie policy e banner | `cookies.json` e `cookie.json` dichiaravano Google Analytics, AdSense, Maps; il banner dice "solo cookie tecnici, niente profilazione ne' analisi"; privacy §9 parlava di "cookie di profilazione previo consenso" | I testi elencano i 4 cookie reali (sessione, XSRF, consenso, "Ricordami") con le durate dell'inventario; `cookie.json` rimanda a `cookies` |
| Cookie realmente impostati (curl `-D -`) | `XSRF-TOKEN` 7200 s, `laravel-session` 7200 s HttpOnly; in ambiente di sviluppo anche `PHPDEBUGBAR_STACK_DATA` (Debugbar, solo sviluppo) | invariato |
| Richieste a terzi nell'HTML (29 pagine servite: 27 della sitemap piu' login, registrazione) | 7 URL `images.unsplash.com` su 5 pagine (audit) | 0 `<iframe>`, 0 `src`/`href` di risorse esterne; solo link in uscita (social, mappe, WhatsApp). Unico residuo: ripiego `onerror` della mappa del footer verso un servizio di segnaposto (richiesta solo se l'immagine locale fallisce; l'immagine locale risponde 200) |
| "ISO 9001" sulle pagine servite | 1 (tessera fissa del login) | 0 |
| Testo inglese della cookie policy | citava il pulsante italiano "Ho capito" | cita "Got it", come il banner inglese (`Gdpr/lang/cookie-consent/en/texts.php`) |
| Logo del login | audit: rettangolo bianco a 1280 px (filtro bianco applicato a un SVG con sfondo pieno) | logo blu visibile (screenshot 1280 px); sorgente: `/img/sottana.com/logo.svg`, stesso host, 200, 661 B |

"Logo di un altro dominio": non confermato. L'URL e' relativo (`MetatagData::getBrandLogo()` da `logo_header` in `config/local/techplanner/metatag.php`), servito dall'host corrente; `sottana.com` e' solo il nome della cartella dell'asset di marchio, tracciata nel repo. Favicon, apple-touch-icon, manifest, `og:image` e logo JSON-LD: tutti stesso host e 200.

## Modifiche

- `Themes/Two/resources/views/pages/auth/login.blade.php`: tolte le tessere fisse "ISO 9001" e "GDPR / conformita' normativa" (nessuna prova di certificazione nel repo; la seconda e' un claim di conformita' non dimostrato). Il logo non riceve piu' il filtro bianco. Aggiunta una `nav` con due link all'informativa e alla cookie policy (`route('container0', ...)`, chiavi gia' esistenti in it/en/de/es di Two, bersagli >= 44 px): e' la formulazione fattuale al posto del claim e porta l'informativa dove si inseriscono le credenziali.
- `cookies.json` (entrambe le copie): "Ho capito" -> "Got it" nel testo inglese.
- `Modules/TechPlanner/tests/Unit/Content/LegalPagesMatchRuntimeTest.php` (nuovo): la cookie policy deve nominare ogni cookie dell'inventario e la sua durata; senza cookie non tecnici dichiarati nessuna pagina legale nomina servizi di tracciamento ne' contiene `<iframe>`; il login non contiene claim di certificazione. Sui testi originali del re-audit i primi due controlli falliscono (nomi assenti, "Google Analytics" e "AdSense" presenti).

Le pagine cookie/privacy/terms sono state riscritte da un'altra sessione mentre lavoravo (vedi "Ripartenza"); le mie verifiche sono contro lo stato disco al momento della misura.

## Owned File/Module Scope

- `Themes/Two/resources/views/pages/auth/login.blade.php`
- `Modules/TechPlanner/config/database/content/pages/{cookie,cookies,privacy,terms}.json` e copia tenant (solo la riga inglese di `cookies.json`; poi bloccati da un'altra sessione)
- `Modules/TechPlanner/tests/Unit/Content/LegalPagesMatchRuntimeTest.php`
- Letti, non modificati: `Modules/Gdpr/lang/cookie-consent/*`, `Modules/Gdpr/app/Actions/Cookie/GetCookieInventoryAction.php`, `config/local/techplanner/metatag.php`

## Acceptance Criteria

- [x] Il banner non contraddice le pagine legali sui cookie impostati (nomi e durate dall'inventario).
- [x] Nessun servizio di tracciamento nominato nelle pagine legali finche' `gdpr.config.cookie.extra` e' vuoto (guardia automatica).
- [x] Nessuna certificazione o conformita' affermata nel login.
- [x] Logo del login visibile e dello stesso host.
- [ ] Dati del titolare, conservazione, basi giuridiche, destinatari, DPO: `DA CONFERMARE` (non inventati; vedi sotto).
- [ ] Link alla cookie policy e "Gestisci cookie" nel footer (decisione/ambito del footer).

## Dev Agent Record

Misure: guardia nuova 3 test verdi; stessa guardia sui testi originali: nessun nome di cookie presente, 2 pagine con servizi di tracciamento (3 nomi: Google Analytics in `cookie` e `cookies`, AdSense in `cookies`). PHPStan sul file di test: 0 errori. Compilazione Blade del login: OK. Login servito 200 in it/en/de/es con i due link che puntano a pagine 200. `PageBlockContractTest`: 1 test rosso non mio (due voci del debito noto sono state sanate da altre sessioni e vanno tolte dall'elenco).

Non verificato: banner in modalita' con consenso (non attiva: nessun cookie non tecnico dichiarato); cookie `remember_*` (richiede login con credenziali); log di accesso del web server e della posta (fornitori non indicati nel repo). Screenshot del login a 390 e 1280 px: logo e link visibili, nessuna sovrapposizione col banner al primo caricamento.

Decisioni dell'utente aperte (`DA CONFERMARE`): ragione sociale e forma giuridica del titolare, indirizzo esatto, DPO, periodi di conservazione, basi giuridiche per finalita', destinatari nominati (hosting, posta), trasferimenti extra-UE, contatto privacy dedicato (la casella canonica per i contatti e' stata scelta dal titolare: se valga anche per i diritti privacy non e' stato detto), PEC come recapito legale, certificazione ISO 9001 (con prova), asset di marchio approvato.

Chiavi lang rese orfane: `pub_theme::ui.sections.quality_certification.label` e `pub_theme::ui.sections.regulatory_compliance.label` in it/en/de/es di Two (non cancellate).

## Ripartenza

1. Prima di scrivere le quattro pagine legali verificare `bashscripts/lock/check.sh` (le tiene un'altra sessione); poi rieseguire `./vendor/bin/pest Modules/TechPlanner/tests/Unit/Content/LegalPagesMatchRuntimeTest.php` e confrontare ogni affermazione nuova con "Cosa risulta".
2. Nei testi riscritti controllare le affermazioni che dipendono da altro lavoro: "il modulo di contatto invia un'e-mail" (vale solo con la rotta di invio attiva), "non c'e' newsletter" (vale solo se il componente e' disabilitato), forma giuridica e indirizzo esatto (non risultano nel repo con questa forma).
3. Footer: aggiungere "Cookie Policy" tra i link legali di `sections/footer.json` e, prima di dichiarare un cookie non tecnico, il trigger `data-cookie-preferences` richiesto dal testo del banner in modalita' consenso.
4. Pagine `de`/`es` delle pagine legali: mostrano l'italiano (noindex) mentre il banner e' tradotto; tradurle solo dopo approvazione del titolare.
