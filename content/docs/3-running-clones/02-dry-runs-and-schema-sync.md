---
title: Dry Runs and Schema Sync
excerpt: Preview row counts and schema differences before transferring data.
---

# Dry Runs and Schema Sync

Run a dry run before transferring production data:

```bash
clonio cloning:run production.cloning.yaml --target staging --dry-run
```

Dry runs validate the YAML, test connections, estimate row counts, and show schema differences between source and target.

## Schema options

Schema synchronization is controlled in `.cloning.yaml` and can be overridden per run.

| YAML option | CLI override | Effect |
|---|---|---|
| `enforce_column_types` | `--enforce-column-types` / `--no-enforce-column-types` | Add missing source columns to target tables. |
| `drop_unknown_tables` | `--drop-unknown-tables` / `--no-drop-unknown-tables` | Drop target tables absent from source. |
| `drop_extra_columns` | `--drop-extra-columns` / `--no-drop-extra-columns` | Drop target columns absent from source. |
| `disable_foreign_key_checks` | `--disable-fk-checks` / `--no-disable-fk-checks` | Disable FK checks during transfer where supported. |

Missing source tables are created on the target automatically unless schema sync is skipped.

## Skip schema sync

If the target schema is already managed by migrations, skip schema replication:

```bash
clonio cloning:run production.cloning.yaml --target staging --skip-schema
```

## Destructive options

`drop_extra_columns` and `drop_unknown_tables` destroy target schema objects. Use them only for disposable targets such as CI databases or environments you can rebuild.
