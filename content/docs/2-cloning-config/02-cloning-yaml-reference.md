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

## Table names

Table names under `tables`, in `skip:`, in `key_remapping` (the remapped table and each `foreign_keys` table) and in the `--skip-tables` / `--only-tables` flags resolve to source tables like this:

1. A name that matches a source table exactly means that table.
2. Otherwise, a name that matches exactly one source table when case is ignored means that table. `Users` resolves to `users`.
3. A name that matches several source tables when case is ignored (the source has both `users` and `Users`) stops the run with exit code `4`. Use the exact name.
4. A name that matches no source table is kept as written. A `tables` entry is then reported as `not_found`.

Two `tables` keys that resolve to the same table (`users` and `Users` with only `users` in the source) also stop the run with exit code `4`. The same goes for two `key_remapping` entries that resolve to the same table, and for a `key_remapping` entry whose table resolves to a table without a `tables` entry.

## Table patterns

A `tables` key or a `skip:` entry written as `/pattern/flags` is a regular expression (PHP PCRE syntax). It stands for every source table whose name matches it. Quote the key in single quotes so YAML keeps it as written:

```yaml
tables:
  '/^logs_\d{4}$/':
    rows:
      strategy: last
      limit: 1000
      sort_by: id
    columns:
      ip_address:
        strategy: "null"
  users:
    rows:
      strategy: full

skip:
  - '/^tmp_/'
```

- The pattern matches the table name as written, so case counts. Add the `i` flag to ignore case: `'/^logs_/i'`. Anchor it with `^` and `$` when it should match the whole name.
- A pattern key becomes one entry per matching table, in source schema order. Its `rows` settings apply to each of them. A column rule applies only to the matching tables that have that column, so one pattern can carry rules for columns some tables lack.
- **Each table may match only one `tables` entry.** A table that a pattern and a name both match, or that two patterns match, stops the run with exit code `4` before anything is copied: `Table "logs_2024" matches more than one tables: entry: "/^logs_/" and "logs_2024". Each table may match only one entry.` To give one table its own settings, leave it out of the pattern, for example with a negative lookahead:

  ```yaml
  tables:
    '/^logs_(?!critical$)/':
      rows:
        strategy: last
        limit: 1000
        sort_by: id
    logs_critical:
      rows:
        strategy: full
  ```

- A `skip:` pattern skips the **configured** tables it matches (the tables your `tables` entries resolve to). Tables without a `tables` entry are not copied anyway.
- A pattern that matches no table prints `Warning: table pattern "/^ghosts_/" matches no table`, also with `--ci`, and is logged as `table_pattern_unmatched`. The run goes on. A pattern key that matches nothing adds no table, so it is not reported as `not_found`.
- A pattern that is not a valid regular expression is a validation error (exit code `4`).
- `key_remapping` needs table names: a pattern as a `key_remapping` table or `foreign_keys` table, and a `strategy: remapping` column under a pattern key, are validation errors.
- `--skip-tables` and `--only-tables` take table names only. A comma inside a pattern would split it, so a flag value that starts with `/` is a validation error.

Glob patterns such as `logs_*` are not supported for table names; use `'/^logs_/'`.

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

### PostgreSQL partitioned tables

Clonio treats a partitioned table as one table. Reading it returns the rows of all its partitions, so the partitions themselves are not listed: `cloning:dump` leaves them out, and a `tables:` entry for a partition (e.g. `events_2026`) is reported as `not_found`. Configure the parent table (`events`) instead. Its `rows` and `columns` rules apply to the rows of every partition.

When Clonio creates the table on the target, it creates a plain, non-partitioned table with the parent's columns. To keep partitioning on the target, create the partitioned table and its partitions there yourself (for example with your migrations) and keep the default `recreate_tables: false`: an existing target table is kept as it is. Rows inserted into the parent are then routed to the matching partition.

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
