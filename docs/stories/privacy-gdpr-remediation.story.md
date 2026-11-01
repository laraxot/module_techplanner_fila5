---
title: "[STORY] GDPR, sicurezza runtime e pre-pubblicazione — TechPlanner"
type: story
module: TechPlanner
theme: Two
status: in-progress
priority: critical
created: 2026-11-01
updated: 2026-11-01
tags: [gdpr, security, accessibility, bmad, techplanner, theme-two]
qmd: "TechPlanner GDPR security runtime privacy cookie contacts newsletter accessibility Theme Two remediation"
issues:
  - "https://github.com/laraxot/base_techplanner_fila5/issues/9"
discussions:
  - "https://github.com/laraxot/base_techplanner_fila5/discussions/10"
---

# [STORY] GDPR, sicurezza runtime e pre-pubblicazione — TechPlanner

## Intento

Portare il sito TechPlanner, servito dal tema Two, a una condizione verificabile
prima della pubblicazione. La priorità è proteggere persone, credenziali e dati,
poi rendere coerenti funzionalità, contenuti multilingua e accessibilità. Questa
story è il punto operativo unico per lo stesso owner: non creare una story per
ogni singolo finding se owner, ciclo e responsabilità non cambiano.

## Evidenze di partenza

- Il rapporto riservato `bashscripts/docs/audit/live-site-reaudit/security-runtime.md`
  misura 1 finding critico, 4 high, 9 medium, 8 low e 4 info.
- Sono stati rilevati file e endpoint di sviluppo raggiungibili, debug runtime,
  credenziali nei file ambiente tracciati e assenza di header di sicurezza.
- I form contatti e newsletter non hanno ancora un flusso completo verificato.
- Policy, banner cookie, contenuti multilingua, alias, claim del login, logo,
  banner sovrapposto all'hero e pagina 404 richiedono riconciliazione.
- Nessun valore di segreto, email reale o credenziale deve essere copiato in
  questa story.

## Regole di sicurezza

1. Prima di operare leggere il rapporto riservato in sola lettura e non
   riprodurre segreti, token, password, IP o payload sensibili.
2. Revoca e rotazione sono ammesse solo con autorizzazione del titolare,
   procedura incident-response approvata, secret manager, piano di rollback e
   verifica post-rotazione. In assenza di autorizzazione il rilascio resta
   `NO_GO`.
3. Nessun database reale, riscrittura della storia Git o cancellazione di
   evidenze senza autorizzazione esplicita.
4. Test dinamici solo con dati sintetici e in ambiente non produttivo.

## Piano ordinato per rischio

### P0 — contenimento sicurezza

- [ ] Rimuovere dal docroot file di diagnostica, placeholder, test e webhook di
      deploy non autenticato, dopo verifica del percorso effettivamente usato.
- [ ] Disabilitare debug bar, debug applicativo, endpoint di monitoraggio e
      strumenti dev nell'ambiente condiviso e in produzione.
- [ ] Revocare e ruotare le credenziali esposte secondo la procedura autorizzata.
- [ ] Rimuovere i file `.env.*` con credenziali dal tracking secondo la policy
      Git del progetto; non usare comandi distruttivi senza piano approvato.
- [ ] Validare host fidati, URL canonici, cookie sicuri, sessioni, autorizzazioni
      e header HTTP in staging.

### P1 — funzionalità e privacy

- [ ] Definire con il titolare una sola casella aziendale canonica, owner,
      accessi, inoltro e fallback; non scegliere un indirizzo per inferenza.
- [ ] Implementare o disabilitare il form contatti: endpoint reale, validazione,
      CSRF, rate limit/antispam, retention, informativa e messaggio non rivelatore.
- [ ] Implementare o disabilitare newsletter: consenso marketing separato,
      consenso dimostrabile, revoca, unsubscribe e provider documentato.
- [ ] Riconciliare codice, cookie banner, cookie policy e privacy policy con una
      matrice verificata di cookie, storage, tracker, fornitori e trasferimenti.

### P1 — accessibilità e contenuti

- [ ] Correggere il form reale della registrazione e i campi della pagina
      contatti; verificare label, errori, focus, tastiera, mobile e traduzioni.
- [ ] Rimuovere claim `ISO 9001` e logo non pertinenti finché il titolare non
      fornisce prova e asset approvato.
- [ ] Correggere contenuti `de`/`es`, alias duplicati e canonical/hreflang.
- [ ] Ricompilare il tema Two solo dopo aver verificato dipendenze, bundle e
      backup; correggere typography e banner cookie senza coprire CTA.
- [ ] Rendere la 404 coerente col layout del tema e verificare status HTTP 404.

## Acceptance criteria

- [ ] Nessun P0 aperto e nessun segreto esposto nei percorsi verificati.
- [ ] Ogni trattamento ha finalità, base, minimizzazione, retention, owner,
      destinatari e procedura di cancellazione documentati.
- [ ] Ogni finding ha evidenza riproducibile, severità, owner, retest e rischio
      residuo; i punti del titolare sono `DA CONFERMARE`.
- [ ] I test includono static scan, HTTP/browser, keyboard, responsive,
      reduced motion, WCAG 2.2 AA e regressione multilingua.
- [ ] PHPStan, Pest e quality gate del progetto sono verdi dopo le modifiche.

## Stato

Audit e piano iniziali completati. Implementazione bloccata sui dati che solo il
titolare può confermare: casella canonica, retention, provider newsletter,
responsabili, trasferimenti, licenze, certificazione e autorizzazione alla
rotazione delle credenziali.

## C1 — identità del login e verifica banner/testi cookie (2026-11-01)

### Claim

Sessione C1: tessere del login (ISO 9001, conformità), logo del login e
confronto tra banner, cookie realmente impostati e testi cookie. Da metà lavoro
i testi legali, il footer e `Modules/Gdpr` sono passati alla sessione f9: dopo
quel passaggio solo lettura.

### Esito

- **Login** (`Themes/Two/resources/views/pages/auth/login.blade.php`): tolte le
  tessere fisse «ISO 9001» e «GDPR / conformità normativa» (nessuna prova di
  certificazione nel repo; la seconda è un claim non dimostrato). Al loro posto
  una `nav` con due link (informativa e cookie policy, `route('container0')`,
  chiavi lang già esistenti in it/en/de/es, bersagli ≥ 44 px). «ISO 9001» sulle
  pagine servite: da 1 a 0. Chiavi lang rese orfane, non cancellate:
  `pub_theme::ui.sections.quality_certification.label` e
  `pub_theme::ui.sections.regulatory_compliance.label`.
- **Logo**: l'URL è relativo (`MetatagData::getBrandLogo()` da `logo_header` in
  `config/local/techplanner/metatag.php`) e servito dall'host corrente (200,
  asset di marchio tracciato nel repo); `sottana.com` è solo il nome della
  cartella. Il difetto vero era il filtro bianco applicato a un SVG con sfondo
  pieno (rettangolo bianco a 1280 px): rimosso nel login, logo visibile a 390 e
  1280 px. Favicon, apple-touch-icon, manifest, `og:image`, logo JSON-LD:
  stesso host, 200. Non confermata l'ipotesi «logo di un altro dominio».
- **Verifica dei testi cookie** (prima del passaggio a f9): banner e inventario
  Gdpr corretti («solo cookie tecnici»); la divergenza era nei JSON. Cookie
  reali: `XSRF-TOKEN` e `laravel-session` a 7200 s (più il cookie di Debugbar
  solo in sviluppo). Su 29 pagine servite: 0 iframe, 0 risorse esterne.
- **Cosa ho modificato nei file ora di f9**: solo `cookies.json` (entrambe le
  copie), riga inglese: «Ho capito» → «Got it», come nel banner inglese. Il testo
  del banner e `privacy`/`terms`/`cookie` non li ho scritti.
- **Test nuovo** `Modules/TechPlanner/tests/Unit/Content/LegalPagesMatchRuntimeTest.php`
  (legge soltanto i JSON): la cookie policy deve nominare ogni cookie
  dell'inventario Gdpr con la durata; finché non ci sono cookie non tecnici
  nessuna pagina legale nomina servizi di tracciamento né contiene `<iframe>`; il
  login non contiene claim di certificazione.

### Dev Agent Record

Misure: guardia 3 test verdi; sui testi originali del re-audit i primi due
controlli falliscono (nessun nome di cookie, 2 pagine con Google Analytics /
AdSense); PHPStan sul test 0 errori; compilazione Blade del login OK; login 200
in 4 lingue con i due link a pagine 200. `PageBlockContractTest`: un test rosso
non mio (due voci del debito noto sanate da altre sessioni, da togliere
dall'elenco).

Non verificato: banner in modalità consenso (non attiva), cookie `remember_*`
(serve il login), log di accesso del web server e della posta, affermazioni
della nuova privacy che dipendono da altro lavoro (invio del modulo contatti,
assenza di newsletter) e dati societari non presenti nel repo (forma giuridica,
indirizzo esatto).

Ripartenza: f9 rilegge la nuova privacy contro la guardia sopra; footer
(link «Cookie Policy», trigger «Gestisci cookie» prima di dichiarare un cookie
non tecnico) e traduzioni de/es delle pagine legali restano a f9. Contatti:
la sostituzione `.net` → `.com` nei JSON alias (contacts 6, contatti 1, faqs 1
per copia) non è stata applicata da C1.
