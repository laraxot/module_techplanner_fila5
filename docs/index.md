# TechPlanner module docs index

Indice unico per `Modules/TechPlanner/docs/`. Nessun file esistente è stato rinominato o cancellato: questo file organizza solo i link.

Per la conoscenza "second brain" orientata AI (frontmatter, tag, qmd) vedi [wiki/index.md](wiki/index.md) — quello resta l'indice canonico per l'harness AI. Questo `index.md` è l'indice umano/di navigazione per l'intero albero `docs/`.

## Start here

- [README.md](README.md) - overview di business del modulo (clienti, appuntamenti, dispositivi, compliance)
- [models-and-relationships.md](models-and-relationships.md) - struttura dati e relazioni principali
- [roadmap.md](roadmap.md) - piano di sviluppo e completamento
- [changelog.md](changelog.md) - changelog del modulo

## Filosofia e principi

- [philosophy.md](philosophy.md) - purpose e design principles del modulo
- [philosophy-complete.md](philosophy-complete.md) - filosofia estesa (logica, religione, politica, zen)
- [companysection-philosophy.md](companysection-philosophy.md) - filosofia del componente CompanySection
- vedi anche "Storico / da consolidare" per le due varianti di `filosofia_modulo_techplanner`

## Architettura e regole XotBase

- [concepts/xotbase-never-extend-filament.md](concepts/xotbase-never-extend-filament.md) - regola: mai estendere Filament\*, sempre XotBase*
- [architecture/non-compliant-relationmanagers-audit.md](architecture/non-compliant-relationmanagers-audit.md) - audit RelationManager non conformi
- [no-ai-tool-scaffold-dirs.md](no-ai-tool-scaffold-dirs.md) - niente directory di scaffold per tool AI nell'albero del modulo
- [independent-repo-upstream.md](independent-repo-upstream.md) - repo indipendente TechPlanner, tracking upstream

## Modelli e dati

- [model-fillable-enum-pattern.md](model-fillable-enum-pattern.md) - pattern fillable con enum
- [addressitemenum-migration-pattern.md](addressitemenum-migration-pattern.md) - pattern di migrazione per AddressItemEnum
- [address-item-enum-integration.md](address-item-enum-integration.md) - integrazione AddressItemEnum nel modulo
- [company-enum-integration.md](company-enum-integration.md) - guida integrazione CompanyEnum
- [nestedset-migration-best-practices.md](nestedset-migration-best-practices.md) - best practice migrazioni NestedSet
- [models/enums-in-fillable-best-practices.md](models/enums-in-fillable-best-practices.md) - approccio professionale enum in fillable
- vedi "Storico / da consolidare" per `models/dynamic-fillable-enums.md` e `models/dynamic_fillable_enums.md`

## Filament: resources e componenti UI

- [filament-resources.md](filament-resources.md) - overview risorse Filament del modulo
- [filament-resources/appointment-resource.md](filament-resources/appointment-resource.md) - dettaglio AppointmentResource
- [relation-managers-setup.md](relation-managers-setup.md) - setup relation manager
- [filament/components/xotbasesection-errors.md](filament/components/xotbasesection-errors.md) - errori comuni XotBaseSection e soluzioni
- [config-icon-key-analysis.md](config-icon-key-analysis.md) - analisi chiave `icon` mancante in config.php
- [content-blocks.md](content-blocks.md) - gestione content block (Filament Builder)

### Compatibilità Filament (versioni)

- [filament-5x-compatibility.md](filament-5x-compatibility.md)
- [filament_4x_compatibility.md](filament_4x_compatibility.md)
- [filament_v4_upgrade_notes.md](filament_v4_upgrade_notes.md)

### AddressSection / ContactColumn

- [addresssection-implementation.md](addresssection-implementation.md)
- [address-contact-columns-plan.md](address-contact-columns-plan.md) - piano
- [address-contact-columns-implementation-complete.md](address-contact-columns-implementation-complete.md) - implementazione completata
- [contacts-column-implementation.md](contacts-column-implementation.md) - implementazione colonna contatti
- [contacts-column-implementation-complete.md](contacts-column-implementation-complete.md) - implementazione completata
- [contacts-column-error-fix.md](contacts-column-error-fix.md) - fix errore colonna contatti

### CompanySection

- [company-section.md](company-section.md) - pattern campi aziendali riusabili
- [companysection-implementation-complete.md](companysection-implementation-complete.md) - implementazione completata

## Mappe e componenti Geo

- [using-geo-components.md](using-geo-components.md) - utilizzo componenti Geo
- [genera-mappa-manuale.md](genera-mappa-manuale.md) - generazione manuale mappa statica
- [mappa-statica-contatti.md](mappa-statica-contatti.md) - mappa statica pagina contatti
- [refactoring/client-coordinate-actions.md](refactoring/client-coordinate-actions.md) - refactor bulk action coordinate client
- vedi "Storico / da consolidare" per `refactoring-update-coordinates.md`

## Refactoring

- [refactoring/client-address-enum-migration.md](refactoring/client-address-enum-migration.md) - refactoring tabella Client con AddressItemEnum
- [refactoring/client-coordinate-actions.md](refactoring/client-coordinate-actions.md) - refactor bulk action coordinate

## Qualità del codice e PHPStan

- [phpstan-level-10-compliance.md](phpstan-level-10-compliance.md) - stato compliance Level 10
- [phpstan-compliance-status.md](phpstan-compliance-status.md) - stato compliance (aggiornamento più recente)
- [phpstan-compliance.md](phpstan-compliance.md) - stato compliance
- [phpstan-complete-fixes.md](phpstan-complete-fixes.md) - riepilogo fix completati
- [phpstan-fixes-implemented.md](phpstan-fixes-implemented.md) - fix implementati
- [phpstan-errors-analysis.md](phpstan-errors-analysis.md) - analisi errori
- [phpstan-widget-formschema-and-pest-bridge-fixes.md](phpstan-widget-formschema-and-pest-bridge-fixes.md) - fix widget formSchema e bridge Pest
- [dry-kiss-improvements.md](dry-kiss-improvements.md) - miglioramenti DRY + KISS
- [clean-code-violation-fix.md](clean-code-violation-fix.md) - fix violazione clean code (UpdateCoordinates action)
- vedi "Storico / da consolidare" per i report qualità generici (`code-quality-improvement-report.md`, `code-quality-report.md`, `quality-analysis-report.md`)

## Testing

- [testing-guide.md](testing-guide.md) - guida ai test del modulo
- [testing-rules.md](testing-rules.md) - riepilogo regole di test
- [testing/pest-testing-guide.md](testing/pest-testing-guide.md) - guida Pest specifica

## Troubleshooting e fix puntuali

- [troubleshooting.md](troubleshooting.md) - guida troubleshooting generale
- [homepage-issues-analysis.md](homepage-issues-analysis.md) - analisi problemi homepage
- [legal-representatives-relationship-fix.md](legal-representatives-relationship-fix.md) - fix relazione Legal Representatives
- [memory-optimization-summary.md](memory-optimization-summary.md) - riepilogo ottimizzazione memoria

## Compliance, notifiche, contenuti

- [gdpr-compliance-analysis.md](gdpr-compliance-analysis.md) - analisi e raccomandazioni GDPR
- [client-notifications.md](client-notifications.md) - aggiornamenti gestione client/notifiche
- [mail_template_translations.md](mail_template_translations.md) - traduzioni template email
- [api-reference.md](api-reference.md) - riferimento API del modulo

## Roadmap collegate

- [blog_replication.md](blog_replication.md) - roadmap replica pagina blog

## Second brain / wiki AI

- [wiki/index.md](wiki/index.md) - indice wiki AI (concepts, entities, rules, skills, memories)
- [wiki/concepts/INDEX.md](wiki/concepts/INDEX.md)
- [wiki/entities/INDEX.md](wiki/entities/INDEX.md)
- [wiki/rules/INDEX.md](wiki/rules/INDEX.md)
- [wiki/skills/INDEX.md](wiki/skills/INDEX.md)
- [wiki/memories/INDEX.md](wiki/memories/INDEX.md)
- [wiki/commands/INDEX.md](wiki/commands/INDEX.md)
- [wiki/log.md](wiki/log.md)

## BMAD

- [stories/docs-index-audit.story.md](stories/docs-index-audit.story.md) - story dell'audit che ha prodotto questo indice

## Storico / da consolidare

File non cancellati/rinominati (per policy) ma sovrapposti o superati da altri documenti in questa lista. Da rivedere in un task dedicato di consolidamento, non in questo audit.

- [00-index.md](00-index.md) - vecchio indice del modulo, sostituito da questo `index.md`; mantenuto per storico
- [FILOSOFIA_MODULO_TECHPLANNER.md](FILOSOFIA_MODULO_TECHPLANNER.md) vs [filosofia_modulo_techplanner.md](filosofia_modulo_techplanner.md) - stesso contenuto, la versione minuscola è più recente (include la sezione "profile e main_module"); la maiuscola andrebbe ritirata in un task di pulizia dedicato
- [models/dynamic-fillable-enums.md](models/dynamic-fillable-enums.md) vs [models/dynamic_fillable_enums.md](models/dynamic_fillable_enums.md) - stesso argomento (fillable dinamico da enum), tagli diversi; da unificare
- [code-quality-improvement-report.md](code-quality-improvement-report.md), [code-quality-report.md](code-quality-report.md), [quality-analysis-report.md](quality-analysis-report.md) - tre report di qualità del codice sovrapposti, snapshot in date diverse
- [phpstan-compliance.md](phpstan-compliance.md), [phpstan-compliance-status.md](phpstan-compliance-status.md), [phpstan-level-10-compliance.md](phpstan-level-10-compliance.md), [phpstan-complete-fixes.md](phpstan-complete-fixes.md), [phpstan-fixes-implemented.md](phpstan-fixes-implemented.md), [phpstan-errors-analysis.md](phpstan-errors-analysis.md) - sei documenti PHPStan sovrapposti nel tempo; `phpstan-compliance-status.md` risulta l'aggiornamento più recente
- [contacts-column-implementation.md](contacts-column-implementation.md), [contacts-column-implementation-complete.md](contacts-column-implementation-complete.md), [contacts-column-error-fix.md](contacts-column-error-fix.md) - sequenza piano/completamento/fix sulla stessa feature, sovrapposti
- [refactoring-update-coordinates.md](refactoring-update-coordinates.md) vs [refactoring/client-coordinate-actions.md](refactoring/client-coordinate-actions.md) - stesso refactor (bulk update coordinate), documentato due volte

## Note

- Standard filename: minuscolo, trattini, niente date nel nome. `README.md` e `CHANGELOG.md` restano maiuscoli. `FILOSOFIA_MODULO_TECHPLANNER.md`, `00-index.md` e i file con `_` sono eccezioni storiche pre-esistenti, non toccate da questo audit.
- Non creare nuovi moduli/temi per la sola documentazione: le story BMAD di questo modulo vivono in `Modules/TechPlanner/docs/stories/`.
