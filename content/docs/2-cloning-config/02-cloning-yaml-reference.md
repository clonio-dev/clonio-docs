---
title: .cloning.yaml Reference
excerpt: Understand the Clonio cloning configuration file format.
---

# `.cloning.yaml` Reference

A `.cloning.yaml` file describes how Clonio transfers and anonymizes one source database. It is safe to commit because it stores a connection name, not credentials.

```yaml
version: "1"
connection: production

options:
  chunk_size: 1000
  enforce_column_types: false
  drop_unknown_tables: false
  drop_extra_columns: false
  recreate_tables: false
  disable_foreign_key_checks: true
  remap_keys: true
  faker_locale: en_US

tables:
  users:
    rows:
      strategy: full
      clear: delete
    columns:
      email:
        strategy: fake
        faker_method: safeEmail
        faker_arguments: []
```

## Top-level fields

| Field | Required | Description |
|---|---:|---|
| `version` | yes | Schema version. Must be `"1"`. |
| `connection` | yes | Source connection name from `clonio.json`. |
| `options` | yes | Global transfer and schema settings. |
| `tables` | yes | Per-table transfer rules. |

## Options

| Field | Description |
|---|---|
| `chunk_size` | Rows fetched and inserted per batch. |
| `enforce_column_types` | Add source columns missing from the target. |
| `drop_unknown_tables` | Drop target tables absent from the source. |
| `drop_extra_columns` | Drop target columns absent from the source. Destructive. |
| `recreate_tables` | Optional, default `false`. Drop each selected table that already exists on the target and re-create it from the source schema. Destructive. See "Recreating drifted tables" in [Dry Runs and Schema Sync](../3-running-clones/02-dry-runs-and-schema-sync.md). |
| `disable_foreign_key_checks` | Disable target FK checks during transfer where supported. |
| `remap_keys` | Optional, default `true`. Set to `false` to skip [key remapping](04-key-remapping.md) while keeping its definition. |
| `faker_locale` | Faker locale for `fake` strategies, such as `en_US` or `de_DE`. |

## Row strategies

| Strategy | Description |
|---|---|
| `full` | Copy all rows. |
| `first` | Copy the first `limit` rows ordered by `sort_by` or primary key. |
| `last` | Copy the last `limit` rows ordered by `sort_by` or primary key. |
| `schema` | Create the table on the target but copy no rows. `rows.clear` is still honoured. |
| `skip` | Leave the table out completely: no schema sync, no rows. Tables with a foreign key to a skipped table are skipped too. |

`rows.clear` can be `false`, `delete`, or `truncate`.

### Schema-only tables

Use `schema` for tables whose structure the application needs but whose rows are transient or sensitive: cache, sessions, queues, password reset and API tokens, debug logs. [`cloning:dump`](../6-commands/09-cloning-dump.md#framework-tables) suggests it for known framework tables.

```yaml
tables:
  sessions:
    rows:
      strategy: schema
      clear: delete   # optional: empty existing target rows
```

Unlike `skip`, `schema` does not cascade: tables that reference a schema-only table are still copied, and their foreign key values point to rows that do not exist on the target. `cloning:run` adds a note to the table result, and inserts fail when foreign key checks are enabled (`disable_foreign_key_checks: false`). `first`/`last` with `limit: 0` is rejected; use `schema` instead.

## Columns

Only list columns that need transformation. Unlisted columns are kept as-is.

```yaml
columns:
  email:
    strategy: fake
    faker_method: safeEmail
    faker_arguments: []
```

See [Anonymization Strategies](03-anonymization-strategies.md) for strategy details.

To leave a column out of the transfer entirely, use `strategy: exclude`. Generated columns are detected and left out automatically.
