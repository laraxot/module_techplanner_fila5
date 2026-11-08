---
title: SEO Head Deep Verification — Sottana Service
type: audit
tags: [seo, head, verification, techplanner, sottana-service, theme-two]
---

# SEO Head Deep Verification — Sottana Service

**Owner:** Techplanner Module
**Date:** 2026-11-01
**Status:** Consolidated from bashscripts audit units

## Purpose

Verify the `<head>` section of the Sottana Service theme for SEO correctness, accessibility, and technical health. This audit consolidates findings previously scattered across bashscripts audit units into a single project-specific artifact under `laravel/Modules/TechPlanner/docs/audits/`.

## Source Material

This document consolidates findings from the following bashscripts audit units (shared, read-only references):

- `bashscripts/ai/wiki/audits/units/theme-two-audit.md` — Theme Two served at `http://192.168.1.40:8000`
- `bashscripts/ai/wiki/audits/units/i18n-blade-theme-two-chrome.md` — CMS title "Consulenza Sicurezza Studi Professionali | Sottana Service"
- `bashscripts/ai/wiki/audits/units/module-lang-audit.md` — `Sottana Service - Home` fragment

## Verification Scope

1. **Title tag** — presence, uniqueness, length, keyword placement
2. **Meta description** — presence, uniqueness, length, value proposition
3. **Canonical URL** — presence, correctness, self-referential
4. **Open Graph tags** — `og:title`, `og:description`, `og:image`, `og:type`, `og:url`
5. **Twitter Card tags** — `twitter:card`, `twitter:title`, `twitter:description`, `twitter:image`
6. **Viewport meta** — mobile responsiveness
7. **Robots directives** — index/follow vs noindex/nofollow
8. **Structured data** — JSON-LD presence, schema type correctness
9. **Favicon / icons** — presence, sizes, rel attributes
10. **Preload / resource hints** — critical asset preloading
11. **Language attributes** — `lang` on `<html>`, `hreflang` correctness
12. **Charset / content-type** — UTF-8 declaration

## Known Issues (from audit fragments)

| Issue | Source | Severity |
|-------|--------|----------|
| CMS title "Consulenza Sicurezza Studi Professionali | Sottana Service" may exceed 60 characters | `i18n-blade-theme-two-chrome.md` | Medium |
| Fragment "Sottana Service - Home" suggests inconsistent title format across pages | `module-lang-audit.md` | Low |
| Theme Two served at `http://192.168.1.40:8000` — canonical may not match production domain | `theme-two-audit.md` | High |

## Remediation Plan

1. Standardize title format to `{Page} | Sottana Service` (max 60 chars)
2. Ensure canonical URL reflects production domain, not local dev IP
3. Audit all OG/Twitter tags for completeness
4. Add structured data for Organization and LocalBusiness schema types
5. Verify favicon and icon declarations across all themes

## BMAD Alignment

- **Story:** Part of Techplanner viral/filament blueprint initiative
- **Acceptance Criteria:**
  - [ ] All 12 verification points documented with pass/fail status
  - [ ] Each failing item has a remediation ticket or PR link
  - [ ] Re-verification after remediation confirms zero critical failures
- **Dependencies:** Fixcity module (core citizen-reporting, not removable)

## Second Brain Links

- Related: `bashscripts/ai/wiki/audits/project-audit.md` (599 findings across 24 reports)
- Related: `laravel/Modules/Techplanner/docs/wiki/` (module documentation root)