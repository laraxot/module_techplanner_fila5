---
title: "Verifica profonda SEO dell'head di Theme Two"
type: audit
module: TechPlanner
theme: Two
status: verified-with-open-items
tags: [seo, head, theme-two, techplanner, accessibility, performance]
created: 2026-10-30
updated: 2026-11-01
qmd: "techplanner theme two seo head deep verification canonical schema hreflang performance accessibility"
issues:
  - "https://github.com/laraxot/base_techplanner_fila5/issues/9"
discussions:
  - "https://github.com/laraxot/base_techplanner_fila5/discussions/10"
related:
  - ../index.md
  - ../../../../../../docs/stories/seo-head-maximum-schema-org-hreflang.story.md
---

# Verifica profonda del `<head>` di Two (TechPlanner)

Sessione 97f16a39 (corsia C), 2026-10-30, solo GET su `http://192.168.1.40:8000` (tema Two). Hub pubblico: `docs/stories/seo-head-maximum-schema-org-hreflang.story.md`.
Questo audit appartiene al modulo TechPlanner perché descrive il brand, il tenant e il tema pubblico di questo progetto. `bashscripts` deve contenere solo procedure e conoscenza riutilizzabile tra progetti; qui registriamo invece misure, decisioni e debito SEO specifici di TechPlanner.
Completa `units/theme-two-audit.md` (TWO-006 SEO, TWO-007 asset) e `units/module-seo-audit.md`, scritti prima che il componente `Head` esistesse.

## 1. Origine degli URL assoluti non fissata da configurazione

Canonical, `og:url`, hreflang, sitemap e riga `Sitemap:` di `/robots.txt` prendono l'origine dalla richiesta in ingresso, non da una configurazione fissa. Dietro una cache o un CDN questo puo' far servire URL assoluti sbagliati ai motori di ricerca.
Questo repo e' pubblico: la procedura di verifica e lo stato della configurazione degli host non sono riportati qui.
Proposta (decisione dell'utente/corsia A, servono gli host di produzione): fissare l'origine da `config('app.url')` per canonical, alternates, sitemap e robots, oppure configurare gli host fidati di Laravel. Le URL assolute del `<head>` sono prodotte da `Cms\View\Components\Head` e dalle action `Cms\Actions\Head\*`; sitemap e robots stanno in `Seo\Actions`.

## 2. Meta duplicati

- Aggiornamento 2026-10-31: la prima misura (stessa description su tutte le pagine di una lingua) e' **superata**. Ora ogni pagina ha la sua description, presa dal `subtitle` del primo blocco CMS, e il `WebPage` JSON-LD la ripete. Le uniche description uguali sono quelle di login e registrazione, che sono `noindex` e usano il testo della home.
- Titoli doppi rimasti, tutti su coppie di alias con contenuto doppio, entrambi in sitemap e con canonical a se' stessi (quindi nessun consolidamento): `about`/`chi-siamo`, `contacts`/`contatti`, `cookie`/`cookies` (in `it` e in `en`); anche `faq`/`faqs`. Serve scegliere un URL per coppia (301 oppure canonical sull'altro).
- Description corte: `/it/cookie` 31 caratteri, `/it/terms` 63, `/it/chi-siamo` 65, `/it/about` 68. Non e' un errore.
- Verificato: query string (`?utm_source=...`, `?page=2`) non entra nel canonical; slash finale e maiuscole nella lingua rispondono 301 all'URL canonico; le pagine 404 hanno stato 404 e `noindex, follow`.

## 3. Prestazioni (Chrome headless, 6 pagine, mobile e desktop)

Le immagini pesanti sono gia' TWO-007; qui le misure nuove.

- LCP di `/it` in desktop 1.4-2.3 s. L'elemento LCP e' lo sfondo dell'hero (`/themes/Two/images/hero-bg.jpg`): JPEG da 3.5 MB, 4800x4800 px, senza `fetchpriority` ne' preload.
- Altre immagini del CMS pesano 0.9-5.4 MB (testimonial-4 5.3 MB, dr-giulia-bianchi 5.4 MB). Tre pagine CMS puntano a `/images/hero-bg.jpg` (percorso senza `themes/Two`).
- 6 fogli di stile bloccano il rendering nell'head. CLS circa 0. Nessun errore in console, nessuna risposta HTTP >= 400 sulle 6 pagine, nessun overflow orizzontale, un solo `<h1>` per pagina.
- Aggiornamento 2026-11-01: l'hero ora e' `/images/hero-bg-2000.jpg` (copia 2000x2000 JPEG q72 dell'originale, che resta); le pagine che lo usavano (home, contatti, profilo, chi-siamo, radioprotezione e il valore predefinito di `hero/about`) puntano alla copia. Home: immagine trasferita 3532 KB -> 370 KB, LCP desktop 1.3-1.7 s su tre prove. Mancano il preload nell'`<head>` e la rimisura mobile.
- Nessuno strumento di immagini installato (cwebp, convert, vips); c'e' PIL. Le immagini sono tracciate in git: ridurle e' lavoro sugli asset e decisione dell'utente.

## 4. Anti-FOUC e modo scuro

- Lo script di avvio imposta la classe `dark` quando `localStorage.dark_mode === 'true'`: verificato su 12 combinazioni (pagina x viewport x tema), funziona.
- Su `/it/auth/login` con `dark` attiva le etichette (Indirizzo email, Password, Ricordami) e "Mostra password" sono bianche su bianco (contrasto 1.0). In chiaro il contrasto e' 7.31.
- Causa accertata: il login di Two non ha nessuna variante `dark:` (0 occorrenze) e il suo pannello e' bianco fisso. La pagina non e' progettata per il modo scuro.
- Raggiungibilita': nessuna pagina di Two espone l'interruttore (`x-ui.light-dark-switch` sta in `Cms/.../headernav/simple.blade.php`, non usato dal layout di Two; l'HTML della home contiene `dark_mode` solo nello script). La classe `dark` si attiva solo se la chiave e' gia' nel browser, per esempio impostata da un widget del pannello di amministrazione sullo stesso dominio.
- Effetto: raro, ma lo script chiesto nel brief porta Two in un modo scuro che il tema non sa disegnare. Decisioni possibili: (a) dare a Two le varianti `dark:`; (b) caricare lo script solo se il tema espone l'interruttore (flag su `Head`). Non scelgo io: lo script e' nel componente della corsia A.
- Il box del logo a sinistra del login mostrava un rettangolo bianco vuoto sia in chiaro sia in scuro: il filtro `color="white"` imbiancava un logo con sfondo pieno. **Corretto (2026-11-01)**: filtro tolto, logo visibile.
- **Modo scuro del sistema operativo (2026-11-01)**: indipendente dalla classe `dark` di cui sopra. La regola daisyUI `:root:not([data-theme])` ribaltava i token con `prefers-color-scheme: dark` mentre blocchi e login usano colori fissi (titoli delle schede a 1,06:1). **Corretto**: `data-theme="light"` su `<html>` nei layout pubblici e di accesso; scuro e chiaro coincidono. Un vero tema scuro resta un lavoro a parte.

## 5. Coerenza sitemap / robots / politica

- Aggiornamento 2026-11-01: la prima misura (`HIDDEN_SEGMENTS` senza `area-personale` e `notifications`, che `/robots.txt` chiudeva) e' **superata**. Ora `HIDDEN_SEGMENTS` le include e un test di Seo verifica che i segmenti di `BuildRobotsTxtAction::PRIVATE_SEGMENTS` restino un sottoinsieme. Resta una lista scritta in due posti, ma l'allineamento e' controllato.
- La regola "lingue scritte" e' ora una sola (`Cms\Actions\Head\ResolveWrittenLocalesAction`, usata anche dalla sitemap).

## 6. Link interni, contenuti e intestazioni (2026-10-31)

Scansione di tutte le pagine della sitemap (32): 75 link interni unici, 53 risorse (img e link dell'head). Nessuna risorsa non 2xx, nessuna `<img>` senza `alt`, nessun `target="_blank"` senza `noopener`; link esterni solo a linkedin, facebook, instagram, google.

**Corretto in questa passata (4 cause nei dati, verificate dal vivo):**
- `cta_url` inglese e tedesco di `sections/header.json`: `/en/contact` e `/de/kontakt` davano 404 (il pulsante principale dell'intestazione, desktop e mobile, su ogni pagina). Ora `/en/contacts` e `/de/contacts`, gli stessi del menu.
- `pages/services.json`: sei `/en/contact` (404) -> `/en/contacts`.
- `pages/about.json` (3) e `pages/faqs.json` (1): `/contacts` senza prefisso di lingua (404, linkato da `/it/about`, `/en/about`, `/it/faqs`) -> `/it/contacts` nei blocchi `it`, `/en/contacts` nel blocco `en`.
- Le stesse correzioni sono in entrambe le cartelle (`config/local/techplanner/database/content`, quella che il sito legge, e la copia `Modules/TechPlanner/config/database/content`): prima erano identiche, ora lo sono ancora. Originali in scratchpad `cta-backup/`. Aggiornato anche `Themes/Two/docs/header-multilingual-implementation.md`, che dichiarava gli URL sbagliati come previsti.
- Link interni non 200 dopo la correzione: 1 (vedi sotto).

**Aperto (decisioni sui contenuti, non inventabili):**
- `pages/blog.json` blocco `en`: l'unica card in evidenza ("Safety in Dental Practices: Complete Guide 2026") punta a `/en/blog/safety-dental-practices`, che non esiste. O si scrive l'articolo o si toglie la card.
- Lingua `es`: `sections/header.json` ha blocchi solo `it`, `en`, `de`; la home `/es` ricade sull'intestazione italiana, quindi menu e pulsanti portano a pagine `/it/...`. Anche `/de` ha un link a `/it/contatti` nel corpo. Servono i blocchi `es` (testi da fornire/tradurre).
- Articoli del blog in `en` e `de`: `/en/blog/<slug>` risponde 200 con `<h1>` e testo in italiano; il `<head>` li marca correttamente `noindex` (e la sitemap li ha tolti da sola: da 36 a 32 URL). Se l'inglese deve essere indicizzato servono i testi.
- Dati di contatto incoerenti (verificato 2026-11-01): lo stesso studio compare con due indirizzi diversi, `studio@sottana.com` in `sections/footer.json` (quindi nel piede di ogni pagina) e in `pages/faq.json`, `studio@sottana.net` in `pages/contacts.json`, `pages/contatti.json` e `pages/faqs.json`; in piu' c'e' un indirizzo PEC. Quale sia quello vero lo sa solo l'azienda: nessuna correzione fatta. Su `/it/contacts` oggi compaiono entrambi.
- Cifre senza fonte nei contenuti: «150+» e «98%» in `pages/faq.json`, «100+» in `pages/chi-siamo.json`, «garantita» in `pages/about.json`. Se non sono dati reali e documentabili vanno tolte o sostituite prima di qualunque promozione del sito (e non possono finire nel JSON-LD).
- Gli articoli usano un'immagine esterna (`images.unsplash.com`): dipendenza di terzi e IP dei visitatori inviato a un altro dominio; meglio una copia locale.
- Gli articoli hanno data e categoria nei dati ("20 Gennaio 2026"), quindi `BlogPosting` (headline, datePublished, image, publisher = Organization) e' possibile senza inventare nulla, ma manca l'autore e la data e' in forma discorsiva (da convertire). Oggi emettono `WebPage` + `BreadcrumbList`. `BuildPageSchemaAction` e' della corsia A.

**Intestazioni HTTP (ambiente di sviluppo):**
- Il cookie `PHPDEBUGBAR_STACK_DATA` compare su ogni risposta: debugbar attiva; in produzione `APP_DEBUG`/debugbar vanno spenti (non verificabile da qui).
- `/sitemap.xml` e `/robots.txt` mandano `Set-Cookie` di sessione e `Cache-Control: no-cache, private`. Un crawler non ne ha bisogno e una cache condivisa non li tiene. Non l'ho cambiato: finche' l'origine degli URL non e' fissata da configurazione (punto 1) tenerli non cacheable e' la scelta piu' sicura; dopo averla fissata si puo' togliere la sessione e dare `public, max-age`.
- `/` risponde 302 verso `/it` (negoziazione della lingua): corretto per un redirect non permanente. `/admin` reindirizza al login.

**Robots**: `robots.txt` chiude `/{lang}/auth`, `/profile`, ecc. e le stesse pagine hanno `noindex`. Combinate sono contraddittorie: un crawler che non puo' leggere la pagina non vede il `noindex`, e un URL linkato puo' restare in indice senza testo. Va bene se quelle pagine non hanno link esterni; per escluderle con certezza basterebbe il solo `noindex`. Decisione, non difetto.

## 7. Sitemap e robots: misure su questo sito (spostate da `Modules/Seo`)

Queste misure stavano nella story condivisa `Modules/Seo/docs/stories/dcp-274-sitemap-completeness-verification.story.md`; descrivono solo questo sito (tema Two), quindi vivono qui. La story del modulo conserva solo le cause e le correzioni generiche.

**Prima passata (2026-10-30):** `/sitemap.xml` rispondeva 404 perche' `SeoServiceProvider` non definiva `$module_dir` e `$module_ns`: `XotBaseServiceProvider` registrava allora il `RouteServiceProvider` di Xot e le `routes/web.php` di Seo non si caricavano. Dopo la correzione: `GET /sitemap.xml` 200 `application/xml`, 76 URL in 4 lingue con hreflang reciproco, le 19 in `it` tutte 200; `GET /robots.txt` 200 `text/plain`.
Errore mio in quella passata: le rotte scritte come sola stringa di classe, dentro il gruppo con `namespace()` del provider, davano 500 «Invalid route action» e per qualche minuto hanno colpito anche le altre pagine del sito di sviluppo. Con la sintassi `[Classe::class, '__invoke']` rientra.

**Seconda passata (2026-10-30, 16:10 UTC):** i titoli delle pagine CMS esistono solo in `it` ed `en`, quindi `/de/...` ed `/es/...` mostrano il testo italiano e il `<head>` le marca `noindex`; la sitemap le elencava lo stesso (76 URL, meta' `noindex`) con hreflang a quattro lingue. `BuildSitemapAction` ora elenca solo le lingue con titolo scritto e scarta le URL che `ResolveRobotsPolicyAction::isIndexable()` non considera indicizzabili. Misurato: 36 URL (18 `it`, 18 `en`), tutte 200 con `index, follow, max-image-preview:large`; poi 32 quando gli articoli del blog in `en` e due pagine servizi `en` sono diventati `noindex` (vedi sezione 6).

**Dipendenza:** la sitemap dipende da `Cms\Actions\Head\ResolveRobotsPolicyAction`; se viene rinominata, `/sitemap.xml` risponde 500.

**Contenuti che la sitemap mostra (dati del CMS, non codice):** coppie di alias con contenuto doppio (`cookie`/`cookies`, `faq`/`faqs`, `contacts`/`contatti`, `about`/`chi-siamo`), entrambe in sitemap (sezione 2). `/it/profile` era in sitemap pur essendo riservata: ora `profile` e' in `HIDDEN_SEGMENTS` e non compare.

**Non verificato:** il contenuto delle URL di dettaglio di blog e servizi oltre lo stato 200; `BuildRobotsTxtActionTest` e' scritto ma non eseguito (database di test inesistente).

## 8. Altri rilievi aperti (secondo e terzo giro)

Descritti per comportamento, senza percorsi di codice: il repo e' pubblico. Il dettaglio sfruttabile (verifica dell'host) resta fuori dai docs condivisi.

- **Pagine di tema che rispondono 500**: la dashboard (`/it/dashboard`, `noindex`) usa un modello applicativo che questo progetto non ha; `/it/auth/verify-email` referenzia un componente Livewire inesistente. Nessuna delle due e' in sitemap. Sono parte del flusso di autenticazione: decisione dell'utente.
- **Accesso in tema scuro**: etichette dei campi quasi invisibili e cinque regole axe sulla pagina di accesso; preesistente, non del `<head>`. Con il modo scuro del sistema operativo e' **corretto** (vedi sezione 4); resta il caso della classe `dark` attivata da `localStorage`.
- **Selettore di lingua**: elenca anche `de` ed `es` (e `en` dove manca il testo), tutte `noindex` perche' il contenuto e' scritto solo in italiano e in parte in inglese. Non danneggia l'indice; l'utente tedesco o spagnolo vede testo italiano. Nasconderle e' una scelta di prodotto.
- **`robots.txt` e `noindex` si annullano**: se `robots.txt` chiude con `Disallow` le stesse aree che il `<head>` marca `noindex`, il crawler non legge il `noindex`. Tenere `Disallow` solo per l'area di amministrazione.
- **Richieste automatiche di Livewire**: alla prima apertura della pagina di accesso partono da sole due POST. Gli strumenti di audit devono bloccare ogni richiesta non-GET fin dall'inizio.

## 9. Pagine in una lingua con il solo `hero` (corretto)

Il re-audit del markup ha trovato 5 URL inglesi in sitemap, `index, follow`, con meno di 200 caratteri di testo (`about`, `contatti`, `cookie`, `faqs`, `services/radioprotezione`): nel contenuto inglese c'era solo il blocco `hero`, ma la regola «lingua scritta» contava anche un solo blocco, e gli hreflang le accoppiavano a pagine italiane piene.

Ora una lingua e' scritta solo con almeno un blocco che non sia `hero`; un blocco di tipo illeggibile conta come corpo. La regola e' una sola per `<head>`, hreflang e sitemap. Esito misurato: la sitemap passa da 32 a 27 URL, le 5 pagine sono `noindex, follow` e le loro omologhe italiane non dichiarano piu' alcun hreflang nel `<head>` (0 tag `alternate` su 5; i link del selettore di lingua restano); le pagine inglesi piene (`blog`, `faq`, `privacy`, `services`, `terms`, `contacts`, `cookies`, `chi-siamo`) restano indicizzabili. Quando il testo inglese verra' scritto (piu' di un `hero`), le pagine rientrano da sole. Test: 79 passati nel runner isolato.

## 10. Contratto tra i JSON dei blocchi e le viste del tema (re-audit)

Una chiave del JSON che la vista non legge sparisce senza errori e il blocco si vede svuotato. Il re-audit del codice ne ha trovate di gravi in tre blocchi, corrette lato JSON in entrambe le copie (modulo e tenant):

- **Home**: la sezione sulla radioprotezione usava `cards`, la vista legge `points`; ora mostra le sue quattro schede.
- **Servizi (it e en)**: il banner finale usava `subtitle`, `cta_label` e `cta_url`; la vista legge `description` e `cta_primary {label, url}`. Ora il banner ha testo e pulsante verso i contatti.
- **Pagine con CTA semplice**: gia' corrette nel terzo giro.

Per non ripeterlo c'e' una guardia pura (senza database): `Modules/TechPlanner/tests/Unit/Content/PageBlockContractTest.php`. Verifica che ogni chiave di primo livello di un blocco compaia nella vista del tema e che le copie tenant e modulo siano identiche. Il debito che resta (11 voci) e' elencato per nome: un difetto nuovo fa fallire il test, uno sanato va tolto dall'elenco. Voci ancora aperte: sottotitolo e colore di fondo in `chi-siamo` (file in lavorazione in un'altra sessione), il pulsante e i campi del form in `contacts` (alias duplicato di `contatti`), alcune ancore `id` che la vista non emette e a cui nulla punta, e tre dati del footer senza vista (certificazioni, mappa, testimonianze).

**Condivisione degli articoli.** Nuovo blocco `share` del tema Two (`blocks/share/links`) che riusa il componente `x-seo::social-share` del modulo Seo, finora senza nessun chiamante: link a LinkedIn, Facebook, WhatsApp e «Copia link», nelle quattro lingue, senza script di terzi (nulla esce dal sito finche' non si clicca). Aggiunto ai due articoli del blog. Misura: axe 0 violazioni, bersagli a 44 px, nessun overflow a 390 e 1280 px. Il form dei contatti e la newsletter dell'home non inviano nulla (nessuna rotta di destinazione): finche' non lo fanno, ogni altra leva di crescita ha un collo di bottiglia a monte; servono prima le decisioni del titolare (casella di destinazione, conservazione dei messaggi, informativa).

## Non fatto

Nessuna correzione al codice in questa passata, nessun `npm run build`, nessun Pest (`BuildRobotsTxtActionTest` resta non eseguito: database di test inesistente).
