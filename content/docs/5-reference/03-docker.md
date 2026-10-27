---
title: Docker
excerpt: Run Clonio CLI from the GitHub Container Registry image.
---

# Docker

Clonio is published as a multi-arch Docker image:

```text
ghcr.io/clonio-dev/clonio
```

Supported platforms:

- `linux/amd64`
- `linux/arm64`

This page covers the published runtime image for running Clonio. To work on the Clonio source code in a container, see [Local Development](05-local-development.md), which uses a separate dev image.

## Quick start

```bash
docker run --rm -v "$(pwd)":/workspace \
  ghcr.io/clonio-dev/clonio:latest --version
```

The image uses `/workspace` as the working directory. Mount your project root there so `.env`, `clonio.json`, and `.cloning.yaml` resolve as expected.

## Run with environment file

```bash
docker run --rm \
  --env-file .env \
  -v "$(pwd)":/workspace \
  ghcr.io/clonio-dev/clonio:latest cloning:run production.cloning.yaml --target local-dev
```

## Avoid root-owned output files on Linux

```bash
docker run --rm \
  --user "$(id -u):$(id -g)" \
  -v "$(pwd)":/workspace \
  ghcr.io/clonio-dev/clonio:latest cloning:run production.cloning.yaml --target local-dev
```

## Included PHP extensions

The image is based on `php:8.5-cli-alpine` and adds:

| Extension | Used for |
|---|---|
| `pdo_mysql` | MySQL and MariaDB connections. |
| `pdo_pgsql` | PostgreSQL connections. |
| `sqlsrv`, `pdo_sqlsrv` | SQL Server connections (Microsoft ODBC Driver 18). |
| `zip` | [`dump` connection](../1-connections/03-sql-dump-connections.md) archives, including AES-256 encrypted ZIPs. |
| `gd` | PDF rendering of audit logs. |
| `pcntl` | Clean shutdown on `SIGINT` / `SIGTERM`. |

SQLite (`pdo_sqlite`) and the other standard extensions ship with the base image.

## Tags

| Tag | Use |
|---|---|
| `latest` | Interactive local use. |
| `1` | Track latest stable major. |
| `1.2` | Track latest stable minor. |
| `1.2.3` | Exact immutable CI version. |

Pin exact tags in CI.
