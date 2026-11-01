---
title: "Audit GDPR, privacy, cookie e accessibilità"
type: audit
status: no-go
tags: [gdpr, privacy, cookie, accessibility, wcag, security, techplanner]
qmd: "GDPR privacy cookie security runtime forms newsletter multilingual A11Y-001 A11Y-002 typography cookie banner 404"
sources:
  - "https://eur-lex.europa.eu/eli/reg/2016/679/oj"
  - "https://www.garanteprivacy.it/garante/document?ID=9677876"
  - "https://www.edpb.europa.eu/our-work-tools/our-documents/guidelines/guidelines-052020-consent-under-regulation-2016679_en"
  - "https://www.w3.org/TR/WCAG22/"
---

# Audit GDPR, privacy, cookie e accessibilità

## Perimetro e metodo

Esecuzione del prompt condiviso `bashscripts/docs/prompts/63-gdpr.md` sul
progetto corrente. Il rapporto runtime riservato è stato letto per primo; non
sono riportati valori di segreti, credenziali, token, IP o dati personali.
L'esito è `NO_GO`: esistono finding di sicurezza e funzionalità incompleta che
impediscono di dichiarare conformità o pubblicabilità.

## Finding prioritari

| ID | Severità | Evidenza verificata | Correzione richiesta | Stato |
|---|---|---|---|---|
| SEC-001 | P0 | Il rapporto runtime ha verificato l'esposizione; nel working tree `info.php` e `default.php` risultano già rimossi, ma revoca/rotazione e verifica HTTP negativa non sono provate | Revocare/ruotare le credenziali compromesse tramite secret store; verificare che gli endpoint rispondano 404 e che i segreti non siano più validi | Parzialmente mitigato |
| SEC-002 | P1 | webhook `public_html/deploy/` tracciato senza firma HMAC verificata | Rimuovere il webhook o proteggerlo con firma, filtro IP reale e deploy sicuro; non eseguire i suoi endpoint durante l'audit | Aperto |
| SEC-004 | P1 | file `.env` non di esempio tracciati e credenziali riutilizzate | Revocare/ruotare, rimuovere dal tracking con procedura approvata, mantenere solo esempi senza valori | Aperto |
| SEC-005/006/007 | P1 | debug/errori/header/Host non sicuri nel runtime auditato | Produzione senza debug, error pages sicure, trusted hosts e header applicati/verificati in staging | Aperto |
| A11Y-001 | P1 | registrazione mostra un widget astratto invece del form | Ripristinare form reale, label, errori, focus, consenso e submit verificato | Aperto |
| A11Y-002 | P1 | pagina contatti non espone i campi previsti dal contratto | Allineare view, route/action, validazione, informativa e stato d'invio | Aperto |
| PRIV-001 | P1 | cookie/privacy dichiarano trattamenti da confrontare con il runtime | Allineare testo, banner, registro consenso e tracker realmente caricati | Aperto |
| FORM-001 | P1 | contatti/newsletter non hanno invio effettivo verificato | Confermare una sola email aziendale, retention, accessi, endpoint, antispam e informativa; implementare o disabilitare | Aperto |
| CONTENT-001 | P2 | pagine `de`/`es` possono contenere italiano residuo | Verificare ogni lingua, chiavi, fallback, `lang` e contenuti approvati | Aperto |
| CONTENT-002 | P2 | alias `faq`/`faqs` duplicati | Scegliere canonico, redirect, canonical e link interni senza rompere URL | Aperto |
| CONTENT-003 | P1 | claim `ISO 9001` e logo login richiedono prova/ownership | Rimuovere claim non provato e usare asset del dominio/tenant corrente | Aperto |
| UI-001 | P1 | banner cookie può coprire hero/CTA su mobile; 404 non tematizzata | Correggere safe-area, z-index, focus, tema, lingua e link di recupero | Aperto |
| BUILD-001 | P2 | typography presente nelle dipendenze/configurazione ma bundle effettivo da verificare | Ricompilare solo dopo verifica dell'incidente `public/`, poi testare bundle servito | Aperto |

## Evidenze tecniche correlate

- `laravel/config/local/techplanner/metatag.php` contiene riferimenti a logo
  `sottana.com`: va verificata la corrispondenza con il dominio/tenant attivo.
- Il contenuto CMS contiene entrambe le pagine `faq.json` e `faqs.json`.
- La configurazione del tema Two include `@tailwindcss/typography` e usa
  classi `prose`; la verifica decisiva è sul CSS compilato realmente servito,
  non sulla sola configurazione.
- Il rapporto runtime indica 1 finding critico e 4 high; il dettaglio resta
  nel documento riservato e non viene duplicato qui.
- Nel controllo corrente `git status` mostra `D public_html/info.php` e
  `D public_html/default.php`: sono modifiche già presenti e non sono state
  ricreate né sovrascritte. Il test HTTP locale con Python stdlib ha restituito
  `404` per entrambi; questo non sostituisce la verifica sul server reale.
- Il test HTTP locale ha restituito `500` per `/it`, `/it/privacy` e
  `/it/cookie`, `200` per `/it/contacts` e `404` per `/it/register`: il sito
  non è quindi pronto per un retest UX completo finché le cause delle 500 non
  sono isolate e corrette.

## Decisioni necessarie

1. Confermare la singola casella aziendale per contatti e newsletter.
2. Confermare finalità, basi giuridiche, destinatari e tempi di conservazione.
3. Confermare titolare, ownership del logo e validità di ogni certificazione.
4. Autorizzare il piano operativo di revoca/rotazione nel secret store e il
   deploy in staging per la verifica.

## Retest obbligatori

Ripetere scansione runtime senza dati reali, cookie consent matrix, Playwright
responsive/keyboard, axe con verifica manuale, pagine locali de/es, login,
registrazione, contatti, newsletter, 404, console/rete, build CSS, `git diff
--check` e quality gate del progetto. Finché SEC-001 e i finding P1 non sono
chiusi con evidenza, il risultato resta `NO_GO`; la rotazione e la verifica
negativa di SEC-001 sono ancora obbligatorie.
