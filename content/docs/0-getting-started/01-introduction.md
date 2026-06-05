---
title: Introduction
excerpt: Learn what Clonio CLI is, why it exists, and how it helps teams clone database data safely from the terminal.
---

# Introduction

Clonio CLI is a command-line tool for cloning production-like database data into development, test, staging, and CI environments. It reads from a source database, applies the transformation rules in a `.cloning.yaml` file, synchronizes the target schema where configured, and writes anonymized data to the target.

There is no web application to operate. Clonio is designed for terminal-first workflows: local scripts, Docker, Composer, cron jobs, GitHub Actions, GitLab CI, and other pipeline runners.

## What Clonio CLI solves

Teams need realistic data to test migrations, QA flows, search, reports, billing logic, imports, exports, and edge cases. Raw production copies are risky because they can expose personal data in environments with weaker access controls.

Manual sanitization scripts are hard to maintain, hard to audit, and easy to forget. Clonio turns that process into a reviewed configuration file and a repeatable command.

## Core capabilities

- **Connection management** - store source and target database connections in a local `clonio.json` file with encrypted passwords.
- **PII-aware config generation** - inspect a source database and generate a `.cloning.yaml` with suggested transformations.
- **Column transformations** - use `fake`, `hash`, `mask`, `null`, `static`, or `keep` strategies per column.
- **Row selection** - transfer full tables or only the first/last N rows.
- **Schema synchronization** - create missing tables and optionally add or remove columns/tables on the target.
- **Key remapping** - replace primary keys and rewrite foreign keys consistently.
- **Signed audit logs** - keep tamper-evident evidence of what was run and which configuration was applied.
- **CI-friendly execution** - use `--ci`, exit codes, Docker, or Composer in pipelines.

## License and funding

Clonio CLI is currently MIT licensed. Everyone can use it without usage restrictions, including commercial users.

There is no pricing plan for the CLI. If Clonio is useful to you or your organization, sponsorships and donations are welcome through [GitHub Sponsors](https://github.com/sponsors/clonio-dev). Sponsorship helps fund ongoing maintenance, new database drivers, better anonymization strategies, and documentation.

Feature requests should be submitted in the [clonio-cli issue tracker](https://github.com/clonio-dev/clonio-cli/issues/new/choose) using the **Feature Request** template.

## Typical workflow

```bash
clonio init
clonio connection:add production --production
clonio connection:add local-dev
clonio cloning:dump --connection production
clonio cloning:run production.cloning.yaml --target local-dev
```

## Next steps

- [Installation](02-installation.md)
- [First clone](03-first-clone.md)
- [Managing connections](../1-connections/01-managing-connections.md)
