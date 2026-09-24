# Come Generare Mappa Statica Manualmente

## Obiettivo
Generare mappa statica PNG per pagina contatti usando SOLO servizi gratuiti.

## 🚨 Regola Critica

**MAI usare Google Maps API, Mapbox API o servizi a pagamento.**

**SEMPRE usare solo servizi gratuiti.**

## Metodo 1: Screenshot manuale da Google Maps UI (Raccomandato)

### Procedura Passo-Passo

1. **Aprire Google Maps**
   - Vai su https://www.google.com/maps

2. **Cercare Indirizzo**
   - Cerca: "Via Vanzo 86/A, 31021 Mogliano Veneto"
   - Oppure inserisci coordinate: `45.5633, 12.2506`

3. **Impostare Zoom**
   - Zoom livello 17-18 (per precisione massima)
   - Assicurati che "Via Vanzo 86/A" sia visibile e leggibile

4. **Preparare Screenshot**
   - Usa strumento screenshot del sistema operativo
   - Oppure estensione browser per screenshot area
   - Dimensioni consigliate: 800x600px o superiore

5. **Salvare Immagine**
   - Formato: PNG
   - Nome: `map-via-vanzo.png`
   - Posizione: `laravel/public/modules/techplanner/images/map-via-vanzo.png`

### Verifica Immagine

- [ ] Dimensioni: 800x600px o superiore
- [ ] Formato: PNG
- [ ] Indirizzo "Via Vanzo 86/A" chiaramente visibile
- [ ] Qualità sufficiente per visualizzazione web
- [ ] File salvato nella posizione corretta

## Metodo 2: OpenStreetMap Export API (Se Disponibile)

### URL Pattern

```
https://render.openstreetmap.org/cgi-bin/export?
  bbox=12.2247,45.5548,12.2447,45.5748
  &scale=5000
  &format=png
```

### Parametri

- **bbox**: Bounding box formato `min_lon,min_lat,max_lon,max_lat`
- **scale**: Scala in metri per pixel (5000-10000 per zoom ravvicinato)
- **format**: Formato immagine (`png`, `jpeg`, `webp`)

### Calcolo Bounding Box

```php
$lat = 45.5648;
$lng = 12.2347;
$offset = 0.01; // ~1km intorno al punto

$bbox = ($lng - $offset) . ',' . ($lat - $offset) . ',' . ($lng + $offset) . ',' . ($lat + $offset);
// Risultato: 12.2247,45.5548,12.2447,45.5748
```

### Download con curl

```bash
curl -L "https://render.openstreetmap.org/cgi-bin/export?bbox=12.2247,45.5548,12.2447,45.5748&scale=5000&format=png" \
  -o public/modules/techplanner/images/map-via-vanzo.png
```

**Nota:** Se l'API restituisce errore "Missing or invalid token", usa Metodo 1 (screenshot manuale).

## Metodo 3: Browser Developer Tools

1. Apri OpenStreetMap.org con indirizzo/coordinate
2. Zoom livello 15-16
3. Apri Developer Tools (F12)
4. Usa strumento "Capture screenshot" o estensione browser
5. Salva come PNG nella posizione corretta

## Verifica Finale

Dopo aver generato l'immagine:

```bash
# Verifica file esiste
ls -lh public/modules/techplanner/images/map-via-vanzo.png

# Verifica formato
file public/modules/techplanner/images/map-via-vanzo.png

# Verifica dimensioni (dovrebbe essere > 10KB)
du -h public/modules/techplanner/images/map-via-vanzo.png
```

## Troubleshooting

### Problema: API OpenStreetMap restituisce errore
**Soluzione:** Usa screenshot manuale (Metodo 1)

### Problema: Immagine troppo piccola
**Soluzione:** Aumenta zoom o usa scale più basso nell'API

### Problema: Indirizzo non visibile
**Soluzione:** Aumenta zoom o riduci bounding box

## Riferimenti

- [Regola: Solo Servizi Gratuiti](../../../../.cursor/rules/free-maps-only.mdc)
- [Modulo GEO: Mappe Solo Gratuite](../../Geo/docs/mappe-solo-gratuite.md)
- [OpenStreetMap Export API](https://wiki.openstreetmap.org/wiki/Export_image_api)
