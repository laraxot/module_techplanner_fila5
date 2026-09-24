# Mappa Statica Pagina Contatti

## Obiettivo
Implementare mappa statica cliccabile nella pagina contatti che apre Google Maps per la navigazione.

## Indirizzo
**Via Vanzo 86/A, 31021 Mogliano Veneto TV**
- Coordinate: 45.5633, 12.2506 (calcolate con Nominatim/OpenStreetMap)
- Zoom consigliato: 17-18 per screenshot

## Validazione produzione
- Sito live: https://sottana.net
- Pagina contatti: https://sottana.net/it/contatti
- Verificare mappa e link "Ottieni Indicazioni" dopo deploy (push su `master` = auto-deploy)

## Immagine Mappa

### Posizione File
`public/modules/techplanner/images/map-via-vanzo.png`

### Come Generare l'Immagine

**🚨 REGOLA CRITICA: Usare SOLO servizi gratuiti. MAI Google Maps API, Mapbox API o servizi a pagamento.**

#### Opzione 1: Screenshot Manuale da Google Maps UI (RACCOMANDATO - GRATUITO)
1. Aprire https://www.google.com/maps
2. Cercare "Via Vanzo 86/A, 31021 Mogliano Veneto"
3. Zoom a livello 17-18 (per precisione massima)
4. Fare screenshot dell'area (strumento OS o estensione browser)
5. Salvare come `map-via-vanzo.png` in `public/modules/techplanner/images/`

**Vantaggi:**
- Precisione superiore per indirizzi italiani
- Qualità visiva migliore
- Familiarità utenti con Google Maps
- Gratuito (screenshot manuale, NON API)

**Nota:** Questo è uno screenshot manuale dalla UI di Google Maps, NON una chiamata API. È completamente gratuito e permesso.

#### Opzione 2: Screenshot manuale da Google Maps UI (gratuito)
1. Aprire https://www.openstreetmap.org/
2. Cercare "Via Vanzo 86/A, Mogliano Veneto"
3. Zoom a livello 15-16
4. Fare screenshot dell'area
5. Salvare come `map-via-vanzo.png` in `public/modules/techplanner/images/`

#### Opzione 3: Servizio Online Gratuito
1. Usare servizi gratuiti come [StaticMapLite](https://staticmaplite.org/) (se disponibile)
2. Oppure generare manualmente tramite browser
3. Salvare come `map-via-vanzo.png`

### Verifica Immagine
- [ ] Immagine salvata in `public/modules/techplanner/images/map-via-vanzo.png`
- [ ] Dimensioni: 800x600px o superiore
- [ ] Formato: PNG
- [ ] Indirizzo "Via Vanzo 86/A" chiaramente visibile
- [ ] Marker o indicazione posizione presente
- [ ] Qualità sufficiente per visualizzazione web

## Componente Utilizzato

`pub_theme::components.blocks.map.static-clickable`

### Configurazione JSON
```json
{
    "type": "map",
    "slug": "location-map",
    "data": {
        "view": "pub_theme::components.blocks.map.static-clickable",
        "title": "Dove Siamo",
        "address": "Via Vanzo 86/A, 31021 Mogliano Veneto TV",
        "coordinates": {
            "lat": 45.5633,
            "lng": 12.2506
        }
    }
}
```

## Link Navigazione

Il componente genera automaticamente il link verso Google Maps (link gratuito, NON API):
```
https://www.google.com/maps?q=45.5633,12.2506
```

**Nota:** Questo è un link gratuito a Google Maps per navigazione, non richiede chiave API.

## Note

- L'immagine attuale è un placeholder temporaneo
- Sostituire con mappa reale scaricata da uno dei servizi sopra
- Verificare che l'indirizzo sia chiaramente leggibile
- Testare su dispositivi mobile

## Collegamenti

- [Modulo GEO - Documentazione](../../Geo/docs/static-map-clickable-implementation.md)
- [Tema Two - Documentazione](../../../Themes/Two/docs/static-map-implementation.md)
- [Componente Blade](../../../Themes/Two/resources/views/components/blocks/map/static-clickable.blade.php)
