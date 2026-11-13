# Manuale d'uso TechPlanner

| File | Cosa è |
| --- | --- |
| [manuale-uso.md](manuale-uso.md) | Il manuale, versione Markdown (fonte da modificare) |
| [manuale-uso.pdf](manuale-uso.pdf) | Lo stesso manuale in PDF A4, da stampare o inviare |
| `images/` | I 31 screenshot reali del pannello, con riquadri rossi numerati |
| `build-pdf.sh`, `manual.css` | Rigenerano il PDF dal Markdown |
| `seed-demo.php`, `screenshots.cjs` | Rigenerano dati demo e screenshot |

Regole del manuale: **ogni capitolo ha screenshot**, linguaggio "per principianti", **un capitolo per tipo di utente**
(segreteria, tecnico, amministratore, gestore utenti, visitatori del sito). Dopo ogni modifica al `.md` rigenera il PDF.

## Rigenerare il PDF

```bash
./build-pdf.sh   # richiede pandoc e Playwright con Chromium
# se il Playwright della repo non ha il browser installato:
PLAYWRIGHT_MODULE=/percorso/node_modules/playwright ./build-pdf.sh
```

## Rigenerare gli screenshot

1. Ambiente locale di prova (mai produzione), DB vuoto migrato.
2. `export MANUAL_DEMO_PASSWORD=...` (non committare la password).
3. `php artisan tinker --execute="require 'Modules/TechPlanner/docs/manual/seed-demo.php';"` — utenti demo
   (`super-admin`, due `techplanner::operator`, `user::admin`), clienti, apparecchi, verifiche, chiamate,
   un cliente nel cestino, un appuntamento oggi.
4. Servire il sito con il nome host del tenant demo. Il tenant si ricava da `$_SERVER['SERVER_NAME']`, che il server
   integrato di PHP imposta all'indirizzo su cui ascolta: si aggiunge `127.0.0.1 manuale.local` a `/etc/hosts` e, dalla
   cartella `public_html`, si avvia
   `php -S manuale.local:8000 ../laravel/vendor/laravel/framework/src/Illuminate/Foundation/resources/server.php`
   (`artisan serve` e `php -S 127.0.0.1:8000` aprono il tenant predefinito, non quello demo).
5. `node docs/manual/screenshots.cjs <cartella>` — Playwright, deviceScaleFactor 2 (`PLAYWRIGHT_MODULE` se serve);
   i nomi delle scene corrispondono alle immagini di `images/`.

Fonte di riferimento: `manuale-uso.md` e `manuale-uso.pdf` di questa cartella. Il documento Claude Docs «TechPlanner — Manuale d'uso» è la prima versione (5 novembre) e non contiene le novità del 10-11 novembre.
