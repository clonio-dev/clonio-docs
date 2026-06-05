# CLI-only Docs Redesign Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Replace the current app-oriented Clonio docs with a CLI-only landing page and documentation structure.

**Architecture:** Use Pergament's existing file-based content model. Create a standalone landing page under `content/pages/home.md`, enable pages in `config/pergament.php`, and replace `content/docs` with a concise CLI-only information architecture sourced from the Clonio CLI docs.

**Tech Stack:** Markdown with YAML front matter, Laravel Pergament static export, GitHub Pages workflow.

---

## File Structure

- Create `content/pages/home.md`: CLI-only landing page adapted from `clonio.dev`.
- Modify `config/pergament.php`: enable pages, set homepage to `home`, enable page actions if supported.
- Replace `content/docs/0-getting-started/*.md`: CLI introduction, installation, first clone.
- Replace `content/docs/1-connections/*.md`: connection management and supported DBs.
- Replace old `content/docs/2-clonings` with `content/docs/2-cloning-config`: YAML generation, reference, anonymization, key remapping.
- Replace old `content/docs/3-cloning-runs` with `content/docs/3-running-clones`: run, dry-run/schema sync, CI/CD, selective runs.
- Replace app-only sections with `content/docs/4-audit-and-compliance`: audit logs, channels, GDPR and pseudonymisation.
- Replace CLI/reference leftovers with `content/docs/5-reference`: PII matchers, command reference, Docker, troubleshooting.
- Delete obsolete app-specific docs and screenshot/media files from `content/docs`.

## Tasks

### Task 1: Configure Pergament Homepage

**Files:**
- Modify: `config/pergament.php`
- Create: `content/pages/home.md`

- [ ] Enable `pages.enabled`.
- [ ] Set homepage to `type: page`, `source: home`.
- [ ] Enable `page_actions.enabled` where present.
- [ ] Create a CLI-only landing page with MIT license, sponsorship, and feature-request messaging.

### Task 2: Rebuild Getting Started

**Files:**
- Create/replace: `content/docs/0-getting-started/01-introduction.md`
- Create/replace: `content/docs/0-getting-started/02-installation.md`
- Create: `content/docs/0-getting-started/03-first-clone.md`

- [ ] Replace web-app introduction with CLI positioning.
- [ ] Include MIT license and sponsorship note.
- [ ] Document binary, Composer, Docker, and PHAR installation.
- [ ] Document first workflow: `init`, `connection:add`, `cloning:dump`, review YAML, `cloning:run`.

### Task 3: Rebuild Connections

**Files:**
- Replace: `content/docs/1-connections/01-managing-connections.md`
- Replace: `content/docs/1-connections/02-supported-databases.md`

- [ ] Document connection commands and local `clonio.json` storage.
- [ ] Explain `APP_KEY`, encrypted passwords, `.env`, and `.gitignore` safety.
- [ ] Document supported DB drivers and Docker host networking notes.

### Task 4: Rebuild Cloning Config

**Files:**
- Create: `content/docs/2-cloning-config/01-generating-config.md`
- Create: `content/docs/2-cloning-config/02-cloning-yaml-reference.md`
- Create: `content/docs/2-cloning-config/03-anonymization-strategies.md`
- Create: `content/docs/2-cloning-config/04-key-remapping.md`
- Delete obsolete: `content/docs/2-clonings/*`

- [ ] Document `cloning:dump` and PII auto-detection.
- [ ] Summarize `.cloning.yaml` structure and options.
- [ ] Document anonymization strategies.
- [ ] Document key remapping and FK rewriting.

### Task 5: Rebuild Running Clones

**Files:**
- Create: `content/docs/3-running-clones/01-running-a-clone.md`
- Create: `content/docs/3-running-clones/02-dry-runs-and-schema-sync.md`
- Create: `content/docs/3-running-clones/03-ci-cd.md`
- Create: `content/docs/3-running-clones/04-selective-runs.md`
- Delete obsolete: `content/docs/3-cloning-runs/*`

- [ ] Document `cloning:run` usage and options.
- [ ] Document dry-run and schema sync flags.
- [ ] Add GitHub Actions, GitLab CI, Docker, and Composer examples.
- [ ] Document table selection and optional CI failure handling.

### Task 6: Rebuild Audit and Compliance

**Files:**
- Create: `content/docs/4-audit-and-compliance/01-audit-logs.md`
- Create: `content/docs/4-audit-and-compliance/02-audit-channels.md`
- Create: `content/docs/4-audit-and-compliance/03-gdpr-and-pseudonymisation.md`
- Delete obsolete: `content/docs/4-settings/*`

- [ ] Document signed audit logs and verification.
- [ ] Document audit delivery channels.
- [ ] Explain anonymization vs pseudonymisation and key remapping.

### Task 7: Rebuild Reference

**Files:**
- Create: `content/docs/5-reference/01-pii-matchers.md`
- Create: `content/docs/5-reference/02-command-reference.md`
- Create: `content/docs/5-reference/03-docker.md`
- Create: `content/docs/5-reference/04-troubleshooting.md`
- Delete obsolete: `content/docs/5-ai-workflows/*`, `content/docs/6-references/*`, `content/docs/7-cli/*`

- [ ] Document matcher commands.
- [ ] Provide compact command reference.
- [ ] Document Docker distribution.
- [ ] Add troubleshooting with feature request link.

### Task 8: Verify Static Export and Stale Content

**Files:**
- Generated: `public/`

- [ ] Run `vendor/bin/pergament generate-static public --content-path=content --base-url="https://clonio-dev.github.io" --prefix=/clonio-docs --clean`.
- [ ] Confirm `public/index.html` and new docs directories exist.
- [ ] Search `content/` for stale web-app terms and fix or confirm context.

## Self-Review

- Spec coverage: all landing page, CLI docs, MIT license, sponsorship, feature request, and stale app-content requirements are covered by tasks.
- Placeholder scan: no open TBD/TODO placeholders.
- Scope: one cohesive content migration; no code subsystem split required.
