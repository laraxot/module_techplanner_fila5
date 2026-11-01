---
title: "Re-audit del sito live (tema Two): sintesi, correzioni e piano"
type: audit
module: TechPlanner
theme: Two
status: in-progress
tags: [audit, accessibility, seo, i18n, content, theme-two, techplanner]
created: 2026-11-01
updated: 2026-11-01
qmd: "techplanner re-audit sito live tema two sintesi accessibilita responsive markup contenuti i18n piano priorita correzioni"
related:
  - ./seo-head-deep-verification.md
  - ../index.md
  - ../../../../../Themes/Two/docs/stories/a11y-color-scheme-and-contrast.story.md
  - ../../../../../Themes/Two/docs/stories/blocks-json-contract-and-share.story.md
  - ../../../../../../docs/stories/seo-head-maximum-schema-org-hreflang.story.md
---

# Re-audit del sito live (tema Two)

Questo documento e' la sintesi pubblica e neutra. Il dettaglio per aspetto (con le prove e i punti sfruttabili) sta nei rapporti riservati del repository privato di supporto: qui non ci sono righe di codice di debolezze aperte, host interni ne' payload.

## Metodo

Dodici aspetti, un agente per aspetto con lo stesso brief, strumenti Playwright, axe e curl, solo richieste GET su un server di sviluppo con lo stesso codice e lo stesso ambiente. Punto di partenza: l'audit completo precedente. Core Web Vitals non misurati: il server di sviluppo e' in modalita' debug e carico, i tempi non sarebbero rappresentativi; misurato invece il peso delle pagine (sezione dedicata).

## Esito per aspetto

| Aspetto | Voto | Regge | Da migliorare |
|---|---|---|---|
| Accessibilita' (WCAG 2.2) | B | 0 violazioni axe su 36 pagine a 4 larghezze; tastiera senza trappole; skip link per primo | modo scuro, pagine di accesso, pagine 404, alcuni contrasti, form senza errori associati ai campi |
| Responsive e qualita' visuale | B | 0 overflow orizzontale in 152 caricamenti; 0 immagini deformate | banner cookie sopra i pulsanti dell'hero, pagine legali senza stile tipografico, contenuti segnaposto |
| Markup e dati strutturati | B | `<head>`, JSON-LD, sitemap e pagine di errore coerenti | immagini senza dimensioni, un'icona del sito corrotta, e-mail diverse nei contenuti |
| Qualita' del codice del front office | C | PHP del `<head>` pulito, PHPStan 0 errori su `Modules` | contratti JSON-vista, asset duplicati, peso delle immagini tracciate |
| Resilienza, errori e log | C | 0 errori su 37 pagine pubbliche | pagine del flusso di autenticazione che rispondono 500, 404 non tematizzate |
| Regressioni rispetto al baseline | C | gran parte delle voci corrette | il resto sono decisioni del titolare o lavoro strutturale |
| i18n, contenuti e link | D | 86 link interni su 87 rispondono 200 | de/es con contenuto italiano, e-mail e conteggi incoerenti, alias duplicati |
| Documentazione e second brain | D | documenti recenti in ordine | link relativi rotti nella massa storica, `docs/stories` non indicizzata da QMD |
| Sicurezza, produzione, dipendenze, privacy | | | esito nei rapporti riservati: sono azioni del titolare |

## Peso delle pagine (mobile 390 px, con scorrimento fino in fondo)

Dati trasferiti misurati con Chrome, indipendenti dal tempo di risposta del server. Ogni pagina include circa 300 KB di barra di debug, presente solo in sviluppo.

| Pagina | Richieste | Totale | Immagini | CSS | JS |
|---|---|---|---|---|---|
| `/it` | 40 | 6,1 MB | 3,9 MB | 1,1 MB | 1,0 MB |
| `/it/services` | 43 | 5,8 MB | 3,6 MB | 1,1 MB | 1,0 MB |
| `/it/chi-siamo` | 39 | 3,9 MB | 1,7 MB | 1,1 MB | 1,0 MB |
| `/it/blog` | 38 | 3,6 MB | 1,4 MB | 1,1 MB | 1,0 MB |
| `/en` | 38 | 3,3 MB | 1,1 MB | 1,1 MB | 1,0 MB |
| `/it/contatti` | 38 | 3,0 MB | 0,8 MB | 1,1 MB | 1,0 MB |
| articolo del blog | 36 | 2,6 MB | 0,4 MB | 1,1 MB | 1,0 MB |
| `/it/auth/login` | 39 | 2,3 MB | 0 | 1,1 MB | 1,0 MB |

Cause: JPEG da 0,9 a 3 MB serviti identici a 390 px (le due foto piu' pesanti dell'home e dei servizi pesano da sole 2,2 e 3,0 MB), un solo foglio di stile da circa 1 MB e il JavaScript di Livewire da 0,6 MB su pagine che non lo usano. Direzioni: versioni ridimensionate e in formato moderno con `srcset`, usare le versioni ottimizzate gia' presenti ed evitare che lo script di sincronizzazione le sovrascriva, ridurre il CSS e tenere una sola radice di asset.

## Corretto in questo re-audit (misurato)

- Una lingua conta come scritta solo con titolo e almeno un blocco di contenuto (non il solo `hero`): cinque pagine inglesi vuote sono uscite dalla sitemap (32 a 27 URL), in `noindex` e senza hreflang.
- Chiavi JSON ignorate dalla vista (home, banner dei servizi) e guardia permanente `PageBlockContractTest` (debito noto di 11 voci, solo in calo).
- Blocco di condivisione degli articoli con 4 lingue e bersagli a 44 px.
- Modo scuro del sistema operativo: `data-theme="light"` su `<html>`; titoli e pagine di accesso coincidono con il chiaro.
- Contrasti: eyebrow del blocco «perche' e' critica», statistiche dell'hero, banner CTA dei servizi, link di recupero password, didascalie del pannello di accesso.
- Login: logo visibile; particelle ferme con movimento ridotto.
- Mappa dei contatti: didascalia e link non piu' ritagliati.

Dettagli e misure: storie del tema Two, collegate sopra.

## Piano proposto (priorita')

1. **Azioni del titolare su esposizioni e credenziali**: nel rapporto riservato; non sono codice.
2. **Prima di spingere la condivisione**: form contatti e newsletter oggi non inviano nulla (nessuna rotta di destinazione). Servono casella di destinazione, conservazione dei messaggi e informativa: scelte del titolare, non si inventano. Poi una sola e-mail aziendale nei contenuti e testi cookie e privacy coerenti con il banner.
3. **Contenuto**: de/es reali oppure ritirati dal selettore; alias duplicati (`faq`/`faqs`, `cookie`/`cookies`, `contatti`/`contacts`, `about`/`chi-siamo`); card del blog in inglese che porta a una 404.
4. **Tema Two (richiede ricompilazione degli asset)**: plugin tipografico per le pagine legali; con la ricompilazione, pulizia degli asset duplicati.
5. **Esperienza**: banner cookie che non copre i pulsanti ne' il menu, 404 tematizzata, immagini con dimensioni, schema `Article` per gli articoli, immagine di condivisione per pagina.
6. **Peso**: immagini ridimensionate e in formato moderno (oggi 2-3 MB a foto), CSS ridotto, JavaScript di Livewire solo dove serve.
7. **Piu' avanti**: vero tema scuro, stampa, Core Web Vitals in un ambiente di produzione.

## Regola appresa

Una chiave dei dati di un blocco non letta dalla vista sparisce senza errore; si corregge sempre dal lato JSON e la guardia impedisce che torni.
