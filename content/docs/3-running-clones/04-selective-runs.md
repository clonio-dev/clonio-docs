---
title: Selective Runs
excerpt: Limit a cloning run to specific tables or skip known-heavy tables.
---

# Selective Runs

Use selective runs when you need a smaller dataset, want to debug one table, or need to skip expensive tables in CI.

## Skip tables

```bash
clonio cloning:run production.cloning.yaml --target staging --skip-tables=audit_logs,sessions
```

## Only specific tables

```bash
clonio cloning:run production.cloning.yaml --target staging --only-tables=users,orders
```

`--skip-tables` and `--only-tables` are mutually exclusive. `--only-tables` never widens a run: tables skipped in the YAML (`skip:` or `rows.strategy: skip`) stay skipped. A value without any table name, such as `--only-tables=' , '`, is rejected with exit code `4`.

## Break on first failure

By default, Clonio continues processing other tables after a table failure and reports the full result. Abort immediately with:

```bash
clonio cloning:run production.cloning.yaml --target staging --break-on-failure
```

The audit log is still written.
