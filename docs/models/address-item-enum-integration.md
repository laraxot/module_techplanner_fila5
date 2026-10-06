# AddressItemEnum e Modulo TechPlanner

## Scopo

Questo documento descrive come il modulo TechPlanner utilizza la filosofia di `Modules\Geo\Enums\AddressItemEnum` per:

- **standardizzare** i campi di indirizzo nella tabella `clients`;
- **allineare** i nomi colonna al modello `Address` del modulo Geo;
- **preparare** una futura migrazione verso l'uso polimorfo di `HasAddress`.

## Mappatura concettuale (Client → AddressItemEnum)

La migration `2024_12_26_000007_create_client_table.php` ora utilizza **direttamente** i value di `AddressItemEnum` come nomi colonna per i campi di indirizzo. Non esistono più alias tipo `address` o `city`: il nome colonna è esattamente quello dell'enum.

- `route` → `AddressItemEnum::ROUTE`
- `street_number` → `AddressItemEnum::STREET_NUMBER`
- `locality` → `AddressItemEnum::LOCALITY`
- `administrative_area_level_3` → `AddressItemEnum::ADMINISTRATIVE_AREA_LEVEL_3`
- `administrative_area_level_2` → `AddressItemEnum::ADMINISTRATIVE_AREA_LEVEL_2`
- `administrative_area_level_1` → `AddressItemEnum::ADMINISTRATIVE_AREA_LEVEL_1`
- `country` → `AddressItemEnum::COUNTRY`
- `postal_code` → `AddressItemEnum::POSTAL_CODE`
- `formatted_address` → `AddressItemEnum::FORMATTED_ADDRESS`
- `place_id` → `AddressItemEnum::PLACE_ID`
- `latitude` → `AddressItemEnum::LATITUDE`
- `longitude` → `AddressItemEnum::LONGITUDE`
- `phone` → `AddressItemEnum::PHONE`

In questo modo:

- **DRY**: non esiste più una mappatura duplicata (nome colonna diverso da value dell'enum);
- **KISS**: i form, le query e le validazioni possono usare direttamente `AddressItemEnum::...->value` ovunque;
- **coerenza**: il modello `Client` usa lo stesso vocabolario del modello `Address` e di tutti i componenti frontend del tema.

Questo approccio estende le linee guida di Geo:

- `Modules/Geo/docs/address-item-enum-guide.md`

e segue lo **stile Laraxot delle migrazioni** (blocco `CREATE` + blocco `UPDATE`):

- nel blocco `tableCreate` la migration dei client usa `AddressItemEnum::columns($table, true)` per definire tutti i campi di indirizzo in un solo punto;
- nel blocco `tableUpdate` usa `AddressItemEnum::ensureColumns($table, fn (string $column): bool => $this->hasColumn($column), true)` per aggiungere solo i campi mancanti, rispettando il pattern `if (! $this->hasColumn(...)) { ... }` centralizzato nell'enum.

## Politica e Religione

- **Politica**: TechPlanner non reinventa la struttura degli indirizzi; si appoggia alla tassonomia definita in Geo.
- **Religione**: "Un solo enum per descrivere tutti i pezzi di indirizzo"; nessuna stringa inventata lato TechPlanner.
- **Zen**: Il cliente vede pochi campi semplici (`address`, `city`, `postal_code`...), ma a livello di dominio questi campi sono allineati ai valori di `AddressItemEnum` per future automazioni (geocoding, autocomplete, validazioni nazionali).

## Integrazione futura con HasAddress

A tendere, la tabella `clients` potrà delegare la gestione completa degli indirizzi a `Modules\Geo\Models\Address` e al trait `HasAddress`. In quel caso:

- i campi attuali restano come **cache/denormalizzazione** dei principali pezzi di indirizzo;
- la fonte di verità diventa la relazione polimorfa con `addresses`;
- `AddressItemEnum` resta il contratto semantico per tutti i form e per la validazione frontend/backend.

## Collegamenti

- `Modules/Geo/docs/address-item-enum-guide.md`
- `Modules/Geo/docs/has-address-trait.md`
- `Modules/Geo/app/Enums/AddressItemEnum.php`
- `Modules/TechPlanner/database/migrations/2024_12_26_000007_create_client_table.php`

## Da migliorare (DRY + KISS)

- **Integrare ContactTypeEnum nella documentazione**  
  Il modulo TechPlanner ora usa anche `Modules\Notify\Enums\ContactTypeEnum` per i campi di contatto nella tabella `clients`
  tramite `ContactTypeEnum::columns()` e `ContactTypeEnum::updateColumns()`.  
  *Da fare*: aggiungere una sezione dedicata che spieghi come address e contact schema convivono
  (AddressItemEnum per indirizzo, ContactTypeEnum per canali di contatto) e come ciò riduce la duplicazione.

- **Esempi di migrazione completi (CREATE + UPDATE)**  
  Qui si descrive il pattern `tableCreate`/`tableUpdate`, ma non è riportato lo snippet completo
  della migration reale `create_client_table`.  
  *Da fare*: includere un estratto aggiornato della migration che mostri chiaramente:
  - `AddressItemEnum::columns($table, null, true)` nel blocco CREATE;
  - `AddressItemEnum::columns($table, $this, true)` nel blocco UPDATE;
  - l'utilizzo simmetrico di `ContactTypeEnum` per i contatti.

- **Chiarezza su cache vs fonte di verità**  
  Nella sezione "Integrazione futura con HasAddress" si cita la cache/denormalizzazione,
  ma non è esplicitato quali colonne del client sono considerate cache rispetto al modello `Address`.  
  *Da fare*: aggiungere una tabella riassuntiva che distingua:
  - colonne di `clients` usate come cache (es. `route`, `postal_code`, `latitude`, `longitude`);
  - colonne e relazioni che rappresenteranno la fonte di verità (`addresses` + trait `HasAddress`).
