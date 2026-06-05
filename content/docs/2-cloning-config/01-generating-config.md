---
title: Generating a Cloning Config
excerpt: Use cloning:dump to inspect a source database and generate a reviewable .cloning.yaml file.
---

# Generating a Cloning Config

`cloning:dump` inspects a live source database and writes a `.cloning.yaml` file that describes which tables to transfer and which columns to transform.

```bash
clonio cloning:dump --connection production
```

## What it does

The command:

1. Connects to the named source connection from `clonio.json`.
2. Reads tables and columns.
3. Runs PII auto-detection against column names.
4. Writes a YAML file such as `production.cloning.yaml`.

The file is meant to be reviewed and committed. It contains connection names, not database credentials.

## Useful options

```bash
clonio cloning:dump --connection production --output config/production.cloning.yaml
clonio cloning:dump --connection production --only-pii
clonio cloning:dump --connection production --all-columns
clonio cloning:dump --connection production --locale de_DE
clonio cloning:dump --connection production --ci
```

## Review checklist

- Confirm every sensitive column has an appropriate strategy.
- Add columns that the matcher did not detect.
- Change strategies where needed, for example from `hash` to `fake`.
- Add key remapping for production identifiers that must not survive in test data.
- Choose safe schema synchronization options for your target.

## Next step

Run a dry run before transferring data:

```bash
clonio cloning:run production.cloning.yaml --target staging --dry-run
```
