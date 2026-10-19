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
| `recreate_tables` | `--recreate-tables` / `--no-recreate-tables` | Drop selected target tables that already exist and re-create them from the source schema. |
| `disable_foreign_key_checks` | `--disable-fk-checks` / `--no-disable-fk-checks` | Disable FK checks during transfer where supported. |

Missing source tables are created on the target automatically unless schema sync is skipped.

## Recreating drifted tables

Schema sync never changes the type or length of an existing column. If the target has drifted from the source, for example a `varchar(100)` on the target where the source has `varchar(255)`, inserts can fail with errors such as "Data too long for column".

Set `recreate_tables: true`, or pass `--recreate-tables` for a single run, to rebuild those tables from the source schema before the transfer:

```bash
clonio cloning:run production.cloning.yaml --target staging --recreate-tables
```

What to expect:

- Only tables selected for transfer are dropped and re-created. Tables in `skip:` or not listed under `tables:` stay untouched.
- Target-only indexes, triggers and extra columns on those tables are lost. Foreign keys from the source are not re-created.
- On PostgreSQL the drop uses `CASCADE`, and on SQL Server foreign keys that reference the table are dropped first. Foreign-key constraints on *other* target tables that point at a recreated table are removed as a result. On MySQL, MariaDB and SQLite, foreign-key checks are switched off for the drop and those constraints stay.
- If a table cannot be dropped, for example because of missing privileges, it is reported as a schema failure and skipped.
- The option has no effect with `--skip-schema`.
- For [SQL dump targets](../1-connections/03-sql-dump-connections.md), the dump contains `DROP TABLE IF EXISTS` before each `CREATE TABLE`.

## Generated columns

Generated (computed) columns are detected automatically:

| DBMS | Detected as generated |
|---|---|
| MySQL / MariaDB | `VIRTUAL`, `STORED` or `PERSISTENT` generated columns |
| PostgreSQL | `GENERATED ALWAYS AS (...) STORED` |
| SQLite | `GENERATED ALWAYS AS (...)`, virtual or stored |
| SQL Server | Computed columns (`AS ...`, with or without `PERSISTED`) |

A column is left out of the transfer when it is generated on the source **or** on the target. Source values of generated columns are never copied, because they can be derived from personal data, for example `UPPER(name)`. When the target column is generated, the target database computes it from the anonymized values.

**Clonio does not recreate generation expressions.** The expression only survives when a MySQL or MariaDB source is copied to a target of the same type and Clonio creates the table from the native table definition. In every other case the column is created as a plain, nullable column and stays empty:

- transfers between different database systems, for example MySQL to PostgreSQL
- columns added later with `enforce_column_types`
- [SQL dump targets](../1-connections/03-sql-dump-connections.md)

To keep generated columns, create them on the target yourself, for example with your migrations, and run with `--skip-schema`.

Each affected table gets a note on the console, in the process log and in the **Notes** section of the [audit log](../4-audit-and-compliance/01-audit-logs.md):

```
Note: bookings: Generated columns not copied and left empty: day. The generation expression was not replicated to the target.
```

## Skip schema sync

If the target schema is already managed by migrations, skip schema replication:

```bash
clonio cloning:run production.cloning.yaml --target staging --skip-schema
```

## Destructive options

`drop_extra_columns`, `drop_unknown_tables` and `recreate_tables` destroy target schema objects and data. Use them only for disposable targets such as CI databases or environments you can rebuild.
