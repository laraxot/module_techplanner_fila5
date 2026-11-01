---
title: "Audit GDPR e pre-pubblicazione — TechPlanner"
type: audit
module: TechPlanner
theme: Two
status: in-progress
created: 2026-11-01
updated: 2026-11-01
tags: [gdpr, privacy, security, accessibility, pre-launch, techplanner]
qmd: "TechPlanner GDPR privacy cookie security runtime contacts newsletter accessibility Theme Two prelaunch"
issues:
  - "https://github.com/laraxot/base_techplanner_fila5/issues/9"
discussions:
  - "https://github.com/laraxot/base_techplanner_fila5/discussions/10"
related:
  - "../../stories/privacy-gdpr-remediation.story.md"
  - "../../../../../../bashscripts/docs/prompts/63-gdpr.md"
  - "../../../../../../bashscripts/docs/audit/live-site-reaudit/security-runtime.md"
---

# Audit GDPR e pre-pubblicazione — TechPlanner

## Perimetro

Progetto TechPlanner, tema pubblico Two, con controlli sul codice, contenuti
CMS, configurazione locale e ambiente di audit. Fixcity e altri temi non sono
stati considerati parte del runtime attivo.

## Metodo

Sono stati confrontati policy e contenuti realmente presenti con viste, route,
configurazione, asset e richieste HTTP. Il prompt condiviso
`bashscripts/docs/prompts/63-gdpr.md` è stato migliorato con fonti GDPR/Garante/
EDPB/WCAG 2.2, matrici di trattamento, modalità operative e criteri di
evidenza. Il rapporto security-runtime è stato letto prima del resto dell'audit.

## Findings aperti

| ID | Gravità | Evidenza | Azione richiesta |
|---|---|---|---|
| SEC-001/004 | P0 | file diagnostici e ambienti tracciati con segreti non vuoti | contenimento, revoca/rotazione autorizzata, rimozione sicura |
| SEC-002/003/005 | P1 | deploy/debug/errori di sviluppo raggiungibili | disabilitare o proteggere, poi retest HTTP |
| SEC-006/007/008 | P1 | header, host e cookie non sufficientemente protetti | configurare staging e verificare con host/HTTPS controllati |
| CONTACTS | P1 | form senza destinazione POST applicativa verificata | definire casella, endpoint, retention e informativa |
| NEWSLETTER | P1 | UI senza persistenza/consenso/invio verificati | implementare o disabilitare |
| I18N | P1 | contenuti `de`/`es` e alias da riconciliare | contenuti approvati, canonical e redirect |
| A11Y | P1 | registrazione, contatti, banner e 404 da verificare | test manuali + Playwright/axe + WCAG criterion |
| CONTENT | P2 | claim, logo, licenze immagini e policy incoerenti | prova del titolare o rimozione |

## Decisioni non delegabili

Restano da confermare dal titolare: casella aziendale unica, retention dei
messaggi, provider newsletter e DPA, trasferimenti extra UE, dati del titolare,
validità di certificazioni/claim, licenze degli asset e autorizzazione a ruotare
credenziali. Non sostituire queste decisioni con valori plausibili.

## Gate di pubblicazione

Stato attuale: `NO_GO`. Il gate passa solo dopo chiusura verificata dei P0,
implementazione o disabilitazione dei form, policy coerenti col runtime,
retest cookie/consenso, verifica WCAG 2.2 AA, traduzioni approvate e qualità
tecnica verde. Nessuna dichiarazione di conformità è autorizzata prima del
retest e della validazione professionale dove necessaria.

## Fonti normative

- [GDPR — EUR-Lex](https://eur-lex.europa.eu/eli/reg/2016/679/oj)
- [Garante Privacy — cookie](https://www.garanteprivacy.it/temi/cookie)
- [EDPB — consent](https://www.edpb.europa.eu/our-work-tools/our-documents/guidelines/guidelines-052020-consent-under-regulation-2016679_en)
- [W3C — WCAG 2.2](https://www.w3.org/TR/WCAG22/)
