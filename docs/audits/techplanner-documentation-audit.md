---
title: "TechPlanner documentation integrity audit"
type: audit
module: TechPlanner
status: reviewed
tags: [documentation, bmad, ecc, second-brain, techplanner]
related:
  - ../wiki/entities/control.md
  - ../wiki/entities/client.md
  - ../stories/unified-controls-parental.story.md
  - ../stories/controls-expiry-workflow.story.md
  - ../../../../../bmad-output/techplanner-client-controls-tech-spec.md
  - ../../../../../bmad-output/techplanner-client-controls-experience.md
---

# TechPlanner documentation integrity audit

## Scope and evidence

This review compares the TechPlanner BMAD stories, blueprint, module wiki and
root BMAD output with the current source contracts. Evidence checked:

- `app/Models/Control.php`, its Parental children and `ControlTypeEnum`;
- `database/migrations/*create_controls_table.php`;
- `app/Models/Client.php` and the client list/table query integration;
- the TechPlanner stories for controls, expiry and client distance;
- the root `docs/wiki` index and the Sixteen/Two theme documentation (read-only).

Only documentation under the approved paths was eligible for change.

## Findings resolved

| Finding | Resolution |
| --- | --- |
| `controls.client_id` is nullable, but the Control entity called the client relation mandatory | The entity wiki now documents the nullable import/staging state and its effect on recency projections. |
| The unified-controls story was `done` while Pest could not load the shared Xot test case | The story is `in-progress`; verification distinguishes syntax/PHPStan/STI evidence from the blocked Pest acceptance criteria. |
| The blueprint named the data behavior but not its canonical scope or nullable-client boundary | The blueprint now identifies `scopeWithLatestControlDates()`, `controls()` and the exclusion of unassigned records. |
| Client filter semantics were too broad in the wiki | The wiki now records that RX includes both `rx` and `intraoral`, while the other categories are separate. |

## Remaining contradictions and orphans

1. The two timestamp-named PHPStan story files and
   `competitive-analysis-field-controls.md` violate the project
   filename convention. They were not renamed because links and concurrent
   work must be audited before a recoverable rename. The duplicate PHPStan
   story pair should ultimately have one canonical owner.
2. `docs/wiki` contains path-placeholder files for `concepts`, `rules` and
   `agents`, while the bootstrap links expect directories. The target content
   exists under `bashscripts/ai/wiki`, but repairing that junction would touch
   repository infrastructure outside this focused documentation update.
3. The docs-governance mechanical audit reports broad broken links in legacy
   agent material and missing shared spine artifacts. Those findings are not
   TechPlanner-domain facts and were left unchanged.
4. The client-controls BMAD output remains `implementation-in-progress` because
   Pest/bootstrap and deployment-time migration verification are still open.
   The theme documents contain no TechPlanner-owned source of truth; they were
   reviewed read-only and were not copied into this module.

## Canonical reading order

1. `bmad-output/techplanner-client-controls-tech-spec.md` — product/technical
   contract;
2. `bmad-output/techplanner-client-controls-experience.md` — operator journey;
3. `docs/filament/client-controls-blueprint.md` — UI/query contract;
4. `docs/wiki/entities/client.md` and `control.md` — domain reference;
5. the three related stories — execution status and verification evidence.

Future changes should update the owner document first, then add a short link or
status note elsewhere. Do not create another report for the same contract.
