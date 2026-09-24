# Client Coordinate Bulk Action Refactor

## Perché interveniamo

- **Clean code**: la bulk action `updateCoordinates` viveva direttamente dentro `ListClients` con oltre 40 righe di logica (loop, notifiche, raccolta errori).
- **Riutilizzo**: l'aggiornamento delle coordinate serve anche ad altri moduli (Geo, Job, Tenant) e va centralizzato.
- **Queueability**: l'operazione può richiedere diversi secondi e deve poter girare in background tramite Spatie Queueable Actions.

## Strategia

1. **Filament Action dedicata** in `Modules\Geo\app\Filament\Actions\UpdateClientCoordinatesAction`.
   - Configurata via `setUp()`, con label/icone tradotte (`geo::actions.update_coordinates.*`).
   - Responsabile solo dell'orchestrazione Filament (modal, conferme, notifiche).
2. **Spatie Queueable Action** in `Modules\Geo\app\Actions\Clients\UpdateClientCoordinatesAction`.
   - Input: `Collection<int, Client>` oppure array di ID.
   - Output: DTO con conteggi `success`, `failed`, `errors`.
   - Utilizza `GetAddressDataFromFullAddressAction` ed espone gli errori per logging/monitoring.
3. **ListClients** richiama solo l’action Filament (niente closure inline).
4. **Documentazione e traduzioni** aggiornate nei moduli TechPlanner e Geo.

## Backlog DRY + KISS

- [ ] Estrarre DTO condiviso per i risultati (`UpdateCoordinatesResultData`).
- [ ] Aggiungere logging strutturato in `geo::actions.update_coordinates` (context: client_id, status).
- [ ] Integrare notifiche broadcast per mostrare l’avanzamento in tempo reale.
