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

## Pass secrets

When `clonio.json` stores passwords as `env:NAME` references, pass the variables with `-e NAME`. Without a value, Docker takes it from the calling shell, so the secret does not appear on the command line:

```bash
docker run --rm \
  -e APP_KEY -e CLONIO_ACCEPTANCE_PASSWORD -e CLONIO_LOCAL_DEV_PASSWORD \
  -v "$(pwd)":/workspace \
  ghcr.io/clonio-dev/clonio:latest cloning:run acceptance.cloning.yaml --target local-dev
```

`env:` references need no `APP_KEY` to resolve; `APP_KEY` is still used to sign the audit log. Do not bake `clonio.json` or `.env` into an image, and do not keep them in long-running containers that can reach production. See [Security and Deployment](../4-audit-and-compliance/04-security-and-deployment.md).

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
