---
title: First Clone
excerpt: Run your first Clonio workflow from init to cloning:run.
---

# First Clone

This guide walks through the first CLI-only workflow: initialize Clonio, add connections, generate a cloning config, review it, and run a transfer.

## 1. Initialize the project

Run `init` from the directory where you want Clonio files to live:

```bash
clonio init
```

Clonio looks for `APP_KEY` in the process environment or in a local `.env` file. If none exists, it creates `.env` with a generated key and owner-only permissions.

`APP_KEY` encrypts database passwords in `clonio.json`. Do not commit `.env` or `clonio.json`.

## 2. Add database connections

Add a production/source connection:

```bash
clonio connection:add production --production
```

Add a target connection:

```bash
clonio connection:add local-dev
```

Test connections before generating a config:

```bash
clonio connection:test production
clonio connection:test local-dev
```

## 3. Generate a `.cloning.yaml`

Inspect the source database and generate a starting configuration:

```bash
clonio cloning:dump --connection production
```

The generated file references the source connection by name and includes table rules, row strategies, schema options, and suggested PII transformations.

## 4. Review the YAML

Open the generated file before running it. Confirm that every sensitive column has the right strategy.

Common adjustments:

- Change `hash` to `fake` when a value should not remain linkable.
- Set `rows.strategy` to `first` or `last` to reduce dataset size.
- Add `strategy: remapping` for primary keys that must not remain production identifiers.
- Tune schema options such as `enforce_column_types` or `drop_extra_columns`.

## 5. Run a dry run

Validate the config, test connectivity, estimate rows, and inspect schema differences without transferring data:

```bash
clonio cloning:run production.cloning.yaml --target local-dev --dry-run
```

## 6. Run the clone

When the dry run looks correct:

```bash
clonio cloning:run production.cloning.yaml --target local-dev
```

For CI:

```bash
clonio cloning:run production.cloning.yaml --target staging --ci
```

## What to commit

Commit `.cloning.yaml` files after review. Do not commit `clonio.json`, `.env`, local audit artefacts, or generated logs.
