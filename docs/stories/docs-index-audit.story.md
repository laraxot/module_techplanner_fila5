# Story: docs index audit and cleanup

**Fase BMAD**: Documentazione (docs-only, nessun codice applicativo toccato).

- Audit di `Modules/TechPlanner/docs/` e creazione di `docs/index.md` come indice unico organizzato per argomento.
- Pulizia eseguita: rimossi `FILOSOFIA_MODULO_TECHPLANNER.md` (duplicato di `filosofia_modulo_techplanner.md`) e `models/dynamic_fillable_enums.md` (versione obsoleta). Rinominati in kebab-case: `filament_4x_compatibility.md` → `filament-4x-compatibility.md`, `mail_template_translations.md` → `mail-template-translations.md`, `blog_replication.md` → `blog-replication.md`.
- Documenti spostati in sottodirectory: `models/` (pattern enum, migrazioni, integrazioni), `testing/` (guide, regole, coverage), `refactoring/` (coordinate update), `filament/` (componenti, implementazioni).
- Tutti i riferimenti interni aggiornati. `docs/wiki/index.md` resta l'indice canonico per l'harness AI (second brain); `docs/index.md` è l'indice di navigazione umano per l'intero albero docs.
