# CompanySection – Campi aziendali riusabili

CompanySection è una sezione Filament riusabile del modulo TechPlanner che accorpa i campi aziendali di base usati dal modello `Client`.

## Campi gestiti

- `business_closed`  
- `activity`  
- `company_name`  
- `tax_code`  
- `vat_number`  
- `fiscal_code`

La logica dei campi (tipi, validazione base) è definita nella classe PHP; le etichette, placeholder e testi di aiuto sono demandati ai file di traduzione del modulo, secondo le regole Laraxot (niente `->label()` inline).

## Utilizzo in ClientResource

Nel form di `ClientResource` la sezione viene inclusa così:

```php
'company' => CompanySection::make('company'),
```

Questo permette di mantenere DRY/KISS il form, condividendo la stessa sezione aziendale tra più risorse/pagine in futuro.

## Pattern architetturale

- Estende `Modules\\Xot\\Filament\\Schemas\\Components\\XotBaseSection` (wrapper Laraxot per Filament v4 Schemas).  
- Configura lo schema tramite `setUp()` chiamando:
  - `schema(fn (): array => $this->getFormSchema());`  
  - `columns(2);`  
- Lo schema effettivo dei campi è concentrato in `getFormSchema()`, che restituisce un array di `Forms\\Components\\Component`.

Questo è allineato ai pattern usati in:

- `Modules/Geo/Filament/Forms/Components/AddressSection.php`  
- `Modules/Notify/Filament/Forms/Components/ContactSection.php`

## Da migliorare (DRY + KISS)

- Valutare in futuro l\'introduzione di un enum dedicato ai campi aziendali (simile a `AddressItemEnum` / `ContactTypeEnum`) per centralizzare ulteriormente schema e migrazioni.  
- Aggiornare la documentazione root (`docs/`) per includere un riferimento a CompanySection e al pattern delle sezioni riusabili di TechPlanner.
