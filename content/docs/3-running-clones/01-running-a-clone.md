---
title: Running a Clone
excerpt: Execute a Clonio transfer with cloning:run.
---

# Running a Clone

Use `cloning:run` to validate a `.cloning.yaml`, test connectivity, synchronize the target schema where configured, transfer rows, apply transformations, and write audit artefacts.

```bash
clonio cloning:run production.cloning.yaml --target local-dev
```

## Prerequisites

1. Run `clonio init`.
2. Add source and target connections.
3. Generate and review a `.cloning.yaml` with `cloning:dump`.
4. Test source and target connectivity.

## Common options

| Option | Description |
|---|---|
| `--target=<name>` | Target connection from `clonio.json`. |
| `--dry-run` | Validate and inspect without transferring data. |
| `--ci` | Suppress non-error output; `--target` is required. |
| `--allow-failure` | Exit with `0` even if the run fails. |
| `--audit-channel=<list>` | Override configured audit channels for this run. |
| `--break-on-failure` | Abort immediately on the first table failure. |

## Output modes

Interactive runs show progress and summaries. CI mode keeps output minimal and relies on exit codes.

```bash
clonio cloning:run production.cloning.yaml --target staging --ci
```

Use verbosity flags when troubleshooting:

```bash
clonio cloning:run production.cloning.yaml --target staging -vvv
```

## Audit logs

The audit log is written even when a run fails or aborts early. Configure delivery channels with `audit:add`.
