---
title: "Mappa clienti in /techplanner/admin/clients"
type: decision
created: 2026-11-19
updated: 2026-11-19
tags: [map, leaflet, filament, widget, ui-ux, geo]
related:
  - concepts/techplanner-business-domain.md
  - concepts/last-appointment-purpose.md
  - ../../../../../docs/wiki/concepts/public-asset-deployment.md
---

# Mappa clienti in `/techplanner/admin/clients`

## Scopo operativo

La mappa non è decorativa: serve a **pianificare le uscite** del tecnico —
vedere i clienti geolocalizzati, scegliere il punto di partenza per l'ordine
per distanza, e passare dal pin al record (view/edit) o al contatto telefonico.

## Componenti

- `ClientMapWidget` (`Modules/TechPlanner/app/Filament/Widgets/`) — widget di
  header di `ListClients`, estende **`BaseMapWidget`** (Geo): marker, cluster,
  controlli, fullscreen e permalink vengono dalla vista condivisa
  `geo::filament.widgets.base-map`. `MAX_MARKERS = 500`.
- Il widget dichiara solo: `getMapMarkers()` (con popup HTML server-side),
  `getMapOrigin()` (sessione/cookie), `getMapStrings()` (chiavi
  `techplanner::client.map.*`) e l'azione `setDistanceOrigin` invocata dalla
  mappa via `data-map-method`.
- Dati: `getMarkers()` (label, indirizzo, tel, whatsapp, lat/lng, url
  view/edit), `getOrigin()` (sessione/cookie `user_latitude/longitude`).
- Asset: `Modules/Geo/public/assets/` → `/assets/geo/assets`
  (`leaflet.js`, `leaflet.css`, `leaflet.markercluster.js`, `images/`).

## Decisioni

1. **Render eager** (`$isLazyLoaded = false`): il lazy-load Livewire del widget
   riceveva HTML invece di JSON sulla request di resume e la mappa non
   appariva mai.
2. **Wrapper `<x-filament-widgets::widget>` obbligatorio**: una vista widget
   custom senza wrapper perde le classi `fi-grid-col` → la mappa occupava metà
   larghezza nonostante `columnSpan='full'`. La vista base in Geo lo include;
   vale per **ogni** widget con vista custom.
3. **Cluster** `L.markerClusterGroup`: `maxClusterRadius` funzione dello zoom
   (80 < z12, 45 oltre), `chunkedLoading`, `removeOutsideVisibleBounds`,
   `disableClusteringAtZoom: 15`, `spiderfyOnMaxZoom`, icone `divIcon`
   contestuali (niente PNG). Fallback a marker singoli se la libreria manca.
4. **Controlli ispirati a farmshops.eu**: layer control OSM + satellite Esri,
   scala metrica, geolocalizzazione browser ("centra su di me" con cerchio di
   accuratezza), permalink `#map=lat,lng,zoom` in `location.hash` via
   `replaceState`, popup dimensionati al container.
5. **Fullscreen**: `requestFullscreen` sullo stage con fallback CSS
   `is-fullscreen-fallback` (fixed inset-0) + `invalidateSize` su
   `fullscreenchange`.

## Trappole note

- **Mai scrivere `@script`/`@` in commenti JS nel blade**: Blade interpreta la
  direttiva e corrompe lo script (`Invalid or unexpected token`).
- **`leaflet.css` referenzia `images/*.png`**: servono in
  `public/assets/images/` (layers.png, layers-2x.png, marker-*). Il build Vite
  di Geo ha `emptyOutDir:false` → i file copiati a mano sopravvivono.
- `wire:ignore` sulla root: Livewire non deve rimorphare la mappa.
- `tryInitialize` con retry 30×100ms: lo script può girare prima che il div
  esista nel DOM.

## Verifiche

- Headless Chrome: mappa 1216px (larghezza piena), layer control, scala,
  locate, fullscreen, permalink, cluster (z6→1 cluster, z12→41+41), 0 errori.
