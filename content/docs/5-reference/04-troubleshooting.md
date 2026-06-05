---
title: Troubleshooting
excerpt: Common Clonio CLI setup, connection, Docker, APP_KEY, and schema issues.
---

# Troubleshooting

## `APP_KEY` is missing

Run:

```bash
clonio init
```

In CI, set `APP_KEY` as a secret environment variable. Do not generate a new key for every run if you need to decrypt existing `clonio.json` secrets.

## Encrypted passwords cannot be decrypted

The `APP_KEY` changed. Restore the original key or re-enter passwords:

```bash
clonio connection:update production
```

## Docker cannot reach localhost database

Inside Docker, `localhost` is the container. On Linux, add the host gateway:

```bash
docker run --rm \
  --add-host=host.docker.internal:host-gateway \
  -v "$(pwd)":/workspace \
  ghcr.io/clonio-dev/clonio:latest connection:test production
```

Also verify database bind addresses and grants allow connections from the container network.

## Target schema changes are surprising

Run a dry run first:

```bash
clonio cloning:run production.cloning.yaml --target staging --dry-run
```

Disable destructive options unless the target is disposable:

```bash
clonio cloning:run production.cloning.yaml --target staging \
  --no-drop-unknown-tables \
  --no-drop-extra-columns
```

## A table is too large for CI

Use row limits in `.cloning.yaml`, or skip the table for that run:

```bash
clonio cloning:run production.cloning.yaml --target ci --skip-tables=audit_logs
```

## Key remapping uses too much memory

Use encrypted file-based mapping storage:

```bash
clonio cloning:run production.cloning.yaml --target staging --file-based
```

## Need a feature

Open a feature request at [clonio-dev/clonio-cli issues](https://github.com/clonio-dev/clonio-cli/issues/new/choose) and choose the **Feature Request** template.

If Clonio CLI is useful to you, sponsorships are welcome through [GitHub Sponsors](https://github.com/sponsors/clonio-dev).
