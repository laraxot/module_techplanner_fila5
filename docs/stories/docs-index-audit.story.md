# Story: docs index audit

**Fase BMAD**: Documentazione (docs-only, nessun codice applicativo toccato).

- Audit di `Modules/TechPlanner/docs/` (59 file .md, 12 sottocartelle) e creazione di `docs/index.md` come indice unico organizzato per argomento, senza rinominare o cancellare file esistenti.
- Individuati duplicati/sovrapposizioni: `FILOSOFIA_MODULO_TECHPLANNER.md` vs `filosofia_modulo_techplanner.md`, `models/dynamic-fillable-enums.md` vs `models/dynamic_fillable_enums.md`, tre report di code quality, sei documenti PHPStan compliance sovrapposti, sequenza contacts-column (plan/complete/fix), `refactoring-update-coordinates.md` vs `refactoring/client-coordinate-actions.md`. Tutti raggruppati sotto "Storico / da consolidare" in `index.md`, non eliminati.
- `docs/wiki/index.md` resta l'indice canonico per l'harness AI (second brain); `docs/index.md` è l'indice di navigazione umano per l'intero albero docs.
- Verifica: nessun file `.md` esistente modificato/rinominato/cancellato; solo `docs/index.md` (nuovo) e questa story aggiunti.
