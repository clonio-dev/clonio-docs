# CLI-only Clonio Docs Redesign

## Goal

Rework the Clonio docs site into a CLI-only product and documentation site. The previous web application, API trigger, scheduling, dashboard, profile/security settings, and pricing model must be removed from the content. Clonio should be presented as an MIT-licensed CLI for safe, anonymized database cloning that can be used without restrictions.

## Source Material

- Existing marketing content from `https://clonio.dev/`, adapted to CLI-only use.
- CLI documentation from `/Users/rok/workspace/clonio-dev/clonio-cli/docs`.
- Current docs content in `content/docs`, reused only where it matches CLI behaviour.

## Product Positioning

Clonio CLI helps teams clone production-like database data into development, test, staging, or CI environments while applying anonymization rules, schema synchronization, key remapping, and signed audit logs. It runs inside the user's own infrastructure and is used from the terminal, Docker, Composer, or CI/CD pipelines.

The site must state clearly:

- Clonio CLI is currently MIT licensed.
- Everyone can use Clonio CLI without usage restrictions.
- There is no commercial pricing plan on the docs site.
- Sponsorships and donations are welcome and should be positioned as the way to support ongoing development.
- Feature requests should be submitted through `https://github.com/clonio-dev/clonio-cli/issues` using the `Feature Request` template.

## New Information Architecture

### Landing Page

Create `content/pages/home.md` and enable Pergament pages. The landing page should adapt the current `clonio.dev` messaging to CLI-only use:

- Hero: production-realistic test data without GDPR risk, powered by a CLI.
- Problems: real customer data in test, manual copying, missing audit trail.
- Solution: configure once in `.cloning.yaml`, run from terminal or CI.
- Capabilities: anonymization, schema-aware cloning, key remapping, signed audit logs.
- DevOps fit: Docker, Composer, standalone binary, GitHub Actions, GitLab CI, cron-friendly CLI.
- License/support: MIT licensed, unrestricted use, sponsorship welcome, feature requests via GitHub issues.
- CTAs: read docs, install CLI, request feature, sponsor project.

Remove all references to web UI, one-click app execution, REST API triggers, app scheduling, subscriptions, paid plans, free trials, or revenue-based tiers.

### Docs Structure

Use a new CLI-only docs structure:

1. `0-getting-started`
   - `01-introduction.md`: What Clonio CLI is and when to use it.
   - `02-installation.md`: Standalone binary, Composer dev dependency, Docker image, PHAR if relevant.
   - `03-first-clone.md`: First complete workflow from `clonio init` to `cloning:run`.

2. `1-connections`
   - `01-managing-connections.md`: `connection:add`, `connection:list`, `connection:test`, `connection:update`, `connection:delete`.
   - `02-supported-databases.md`: supported database drivers and practical notes.

3. `2-cloning-config`
   - `01-generating-config.md`: `cloning:dump`, PII auto-detection, reviewing generated YAML.
   - `02-cloning-yaml-reference.md`: `.cloning.yaml` format.
   - `03-anonymization-strategies.md`: `keep`, `fake`, `hash`, `mask`, `null`, `static`.
   - `04-key-remapping.md`: primary-key remapping and foreign-key rewriting.

4. `3-running-clones`
   - `01-running-a-clone.md`: `cloning:run` usage, prerequisites, output, exit behaviour.
   - `02-dry-runs-and-schema-sync.md`: `--dry-run`, schema diff, schema sync flags.
   - `03-ci-cd.md`: GitHub Actions, GitLab CI, Docker and Composer examples.
   - `04-selective-runs.md`: `--skip-tables`, `--only-tables`, optional failure handling.

5. `4-audit-and-compliance`
   - `01-audit-logs.md`: signed audit logs and verification.
   - `02-audit-channels.md`: local, S3, email, Slack, Teams, ntfy, stacks.
   - `03-gdpr-and-pseudonymisation.md`: GDPR context, anonymization limits, key remapping.

6. `5-reference`
   - `01-pii-matchers.md`: matcher commands and customization.
   - `02-command-reference.md`: compact command overview.
   - `03-docker.md`: Docker distribution and recipes.
   - `04-troubleshooting.md`: common setup, connection, Docker, APP_KEY, and schema issues.

## Pergament Configuration

- Enable `pages`.
- Set homepage to `type: page`, `source: home`.
- Keep docs enabled at `/docs`.
- Enable `page_actions` if available in Pergament config.

## Content Rules

- Use concise, practical language for developers and DevOps teams.
- Prefer runnable CLI examples over conceptual descriptions.
- Use `.cloning.yaml`, `clonio.json`, `.env`, and `APP_KEY` consistently.
- Do not document removed web-app functionality.
- Do not imply that Clonio stores production data outside the user's infrastructure.
- Do not mention subscriptions, paid tiers, trials, or revenue thresholds.
- Include MIT license and sponsorship messaging in the landing page and introduction.
- Include feature-request instructions in landing page, introduction, and troubleshooting/reference where appropriate.

## Verification

After implementation:

- Run `vendor/bin/pergament generate-static public --content-path=content --base-url="https://clonio-dev.github.io" --prefix=/clonio-docs --clean`.
- Confirm `public/index.html` and the new docs directories are generated.
- Search content for stale web-app terms: `dashboard`, `web UI`, `API trigger`, `schedule`, `pricing`, `trial`, `subscription`.
