# Roadmap - Blog Page Replication

**Objective**: Replicate `/it/pages/blog` to match `https://lightseagreen-dogfish-560272.hostingersite.com/blog`.

## Current Status (2026-02-07)
- [x] Identified `blog.json` configuration.
- [!] **CRITICAL**: `Modules/Blog` appears to be missing, yet `blog.json` references `blog::components...`.
- [ ] Need to locate or create the missing components.

## Action Plan

### 1. Analysis & Discovery
- [ ] Locate definition of `blog::` view namespace.
- [ ] If module is missing, determine if components exist in `Themes/Two` or need creation.
- [ ] Analyze `blog.blade.php`.

### 2. Component Migration/Creation
- [ ] `hero.enhanced` (from `Themes/Two` or create)
- [ ] `search-bar` (missing?)
- [ ] `category-filter` (missing?)
- [ ] `featured-grid` (missing?)
- [ ] `articles-grid` (missing?)
- [ ] `newsletter.enhanced` (from `Themes/Two`)
- [ ] `cta.consultation` (from `Themes/Two`)

### 3. Implementation
- [ ] Update `resources/views/pages/blog.blade.php`.
- [ ] Ensure `Themes/Sixteen` has all required components.
- [ ] Verify `blog.json` data against available components.

### 4. Verification
- [ ] Visual regression test (manual).
- [ ] Mobile responsiveness check.
