---
title: Clonio CLI
excerpt: Clone production-like database data into dev, test, staging, and CI environments with anonymization, key remapping, and signed audit logs.
layout: landing
seo.title: "Clonio CLI - GDPR-aware database cloning for developers"
seo.description: "MIT-licensed CLI for safe, anonymized database cloning inside your own infrastructure."
---

:::hero

# Test with real data. Without the GDPR nightmare.

Clonio CLI clones production-like database data into development, test, staging, and CI environments while applying anonymization rules, schema synchronization, key remapping, and signed audit logs.

It runs from your terminal, Docker, Composer, or CI pipeline. No web app. No external cloud. No data leaves your infrastructure.

[Read the docs](/docs/getting-started/introduction) [Install the CLI](/docs/getting-started/installation)

MIT licensed. Unrestricted use. Sponsorship welcome.

:::

:::features

## Why Clonio CLI exists

### Realistic data without exposing people

QA and developers need production-like data, but raw production copies expose names, emails, addresses, tokens, IDs, and payment-related fields. Clonio applies explicit transformations before data reaches the target environment.

### Repeatable cloning instead of manual scripts

Generate a `.cloning.yaml`, review it once, commit it, and run it whenever you need fresh data. No more one-off export, sanitize, import, and debug cycles.

### Audit evidence you can keep

Every run can produce signed audit artefacts and structured process logs. Deliver them to local storage, S3-compatible storage, email, Slack, Microsoft Teams, or ntfy.

:::

:::features

## CLI workflow

```bash
clonio init
clonio connection:add production --production
clonio connection:add local-dev
clonio cloning:dump --connection production
clonio cloning:run production.cloning.yaml --target local-dev
```

The generated YAML controls row selection, schema synchronization, anonymization strategies, and key remapping. It is safe to commit because it references connection names, not credentials.

:::

:::features

## Core capabilities

### Privacy-first transformations

Use `fake`, `hash`, `mask`, `null`, `static`, or `keep` per column. Built-in PII matchers help generate a starting configuration, but you stay responsible for reviewing the result.

### Schema-aware transfers

Clonio can create missing tables, add missing columns, and optionally drop stale target tables or columns when your target environment is behind production.

### Key remapping

Primary keys can be replaced with new random values, and foreign keys are rewritten consistently. This reduces the risk of correlating target records back to production IDs.

### DevOps-ready execution

Run Clonio from a standalone binary, PHAR, Composer dev dependency, or Docker image. Use `--ci` in GitHub Actions, GitLab CI, Jenkins, cron jobs, or local scripts.

:::

:::cta

## Open source and sponsor-supported

Clonio CLI is currently MIT licensed. Everyone can use it without usage restrictions, including commercial users.

There is no pricing plan for the CLI docs site anymore. If Clonio saves you time or helps your team stay compliant, sponsorships and donations are welcome and directly support ongoing development.

[Sponsor Clonio](https://github.com/sponsors/clonio-dev) [Request a feature](https://github.com/clonio-dev/clonio-cli/issues/new/choose) [View source](https://github.com/clonio-dev/clonio-cli)

For feature requests, use the GitHub issue template named **Feature Request**.

:::
