---
title: Supported Databases
excerpt: Database drivers and connection notes for Clonio CLI.
---

# Supported Databases

Clonio CLI supports the following connection drivers:

| Driver | Typical use |
|---|---|
| `mysql` | MySQL source or target databases |
| `mariadb` | MariaDB source or target databases |
| `pgsql` | PostgreSQL source or target databases |
| `sqlsrv` | Microsoft SQL Server source or target databases |
| `sqlite` | Local SQLite databases and lightweight test fixtures |

## Source and target

The `.cloning.yaml` file names the source connection:

```yaml
version: "1"
connection: production
```

The target is selected at runtime:

```bash
clonio cloning:run production.cloning.yaml --target local-dev
```

## Docker networking

When running Clonio in Docker, `localhost` points to the container, not the host. Clonio detects container execution and rewrites loopback hostnames to `host.docker.internal` in memory.

On Linux, add the gateway host explicitly or use host networking:

```bash
docker run --rm \
  --add-host=host.docker.internal:host-gateway \
  -v "$(pwd)":/workspace \
  ghcr.io/clonio-dev/clonio:latest connection:test production
```

## Database grants

The database user needs enough permissions for the operation you configure:

- read source schema and rows
- create missing target tables
- add missing target columns when `enforce_column_types` is enabled
- delete or truncate target rows when `rows.clear` is configured
- drop target columns or tables only when destructive schema options are enabled

Use the least privilege that still allows your chosen workflow.
