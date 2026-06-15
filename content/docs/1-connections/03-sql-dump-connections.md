---
title: SQL Dump Connections
excerpt: Write an anonymized transfer to a portable SQL-file archive instead of a live target database.
---

# SQL Dump Connections

A **dump** connection is a virtual output target. When used as the target of `cloning:run`, it produces a dialect-correct SQL file compressed into a (optionally AES-256 encrypted) ZIP archive — **no live target database required**.

This is built for air-gapped or multi-stage environments where the source and target are never directly connected. Clonio anonymizes the source as usual, then writes the result to a portable file you can transport and import on the target system at any time.

> A dump *connection* (a transfer target) is different from the `cloning:dump` *command*, which inspects a database and generates a `.cloning.yaml` config.

## Add a dump connection

`connection:add` lists `Dump (SQL file)` alongside the database drivers. Host, port, database, and username are skipped; you choose a target SQL dialect and an optional ZIP password.

```bash
clonio connection:add staging-dump \
  --type=dump \
  --dialect=pgsql \
  --password="$ZIP_PASSWORD"
```

- `--dialect` (required): the target DBMS — `mysql`, `mariadb`, `pgsql`, `sqlsrv`, or `sqlite`.
- `--password` (optional): ZIP archive password, stored encrypted with `APP_KEY`. Omit for an unencrypted archive.

The resulting `clonio.json` entry:

```json
"staging-dump": {
  "type": "dump",
  "dialect": "pgsql",
  "password": "encrypted:eyJpdiI6..."
}
```

## Test a dump connection

`connection:test` skips the database ping and instead verifies the working directory is writable:

```bash
clonio connection:test staging-dump
```

```
Dump connection "staging-dump" — dialect: pgsql, target: /path/to/project, encryption: AES-256
```

## Run a transfer to a dump

Use the dump connection as `--target`:

```bash
clonio cloning:run production.cloning.yaml --target staging-dump
```

The source connection (a real database) is read and anonymized exactly as for a live target. Schema and data are written to a `.sql` file, then compressed and the intermediate `.sql` deleted:

```
  Tables: 24/24  Rows: 18432  Duration: 4.1s

  Dump: app_20260615_143022.zip  (2.3 MB, AES-256)
```

Both artefacts land in the current working directory:

| Artefact | Pattern |
|---|---|
| ZIP archive (final) | `<source-db>_<YYYYMMDD>_<HHmmss>.zip` |
| SQL file (intermediate, deleted) | `<source-db>_<YYYYMMDD>_<HHmmss>.sql` |

## What the dump contains

- **DDL** follows `options.drop_unknown_tables`: `true` emits `DROP TABLE IF EXISTS` + `CREATE TABLE`; `false` emits `CREATE TABLE IF NOT EXISTS`.
- **Inserts** are batched by `options.chunk_size`, one multi-row `INSERT` per chunk, with per-dialect syntax. Binary columns are hex-encoded.
- **Cross-dialect mapping**: when the source DBMS differs from the dump dialect, column types map conservatively to the widest compatible target type; source length/precision is preserved where possible.
- **Foreign-key handling** follows `options.disable_foreign_key_checks`; data is written in dependency order.

For portability across all dialects, the v1 output omits `AUTO_INCREMENT`/`SERIAL`/`IDENTITY`, `DEFAULT` clauses, and foreign-key constraints — every value (including remapped keys) is copied explicitly.

## Constraints

- The source connection must be a real database — a dump cannot be a source.
- Output is always a ZIP archive (no plain-text option).
- v1 writes a full dump of the selected rows into a single file; importing the dump is a manual step on the target system.
