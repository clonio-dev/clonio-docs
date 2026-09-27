---
title: Managing Connections
excerpt: Add, test, update, list, and delete database connections for Clonio CLI.
---

# Managing Connections

Clonio stores database connections in `clonio.json` in the current working directory. Passwords and other secrets are encrypted with `APP_KEY` from your environment or `.env` file.

Run commands from the project directory that owns the cloning configuration.

## Initialize encryption

```bash
clonio init
```

This ensures `APP_KEY` exists. If `.gitignore` already exists, Clonio adds `.env` and `clonio.json` when missing.

## Add a connection

```bash
clonio connection:add production --production
```

Without flags, Clonio prompts for:

- connection name
- driver: `mysql`, `mariadb`, `pgsql`, `sqlsrv`, or `sqlite`
- host and port
- database name or SQLite path
- PostgreSQL schema when relevant
- username and password
- transport security for network drivers: `require` (default, except SQL Server which defaults to `verify`), `verify`, `disable` or driver default, plus certificate paths when needed (see [Transport Security](04-transport-security.md))
- whether this is a production connection

Non-interactive example:

```bash
clonio connection:add production \
  --type=pgsql \
  --host=db.internal \
  --port=5432 \
  --database=app \
  --schema=public \
  --username=clonio \
  --password="$DB_PASSWORD" \
  --ssl-mode=verify --ssl-ca=certs/production-ca.pem \
  --production
```

New network connections use `--ssl-mode=require` when no mode is given, except SQL Server which uses `--ssl-mode=verify` (ODBC Driver 18 already verifies by default). A server without TLS, such as the stock `postgres` Docker image, needs `--ssl-mode=disable`.

## List connections

```bash
clonio connection:list
```

Use this to confirm the names you will reference from `.cloning.yaml` and `--target`.

The `TLS` column shows each connection's transport security mode (`default`, `disable`, `require`, `verify`).

## Test a connection

```bash
clonio connection:test production
```

Test both source and target before running `cloning:dump` or `cloning:run`.

A successful test shows the transport security mode:

```text
production: OK (42ms, tls: require)
```

Add `-v` to also see the negotiated TLS cipher. SQL Server does not report the cipher, so it shows `encrypted (cipher not reported by SQL Server)` instead.

Without a name, every connection is tested and the results are shown as a table:

```bash
clonio connection:test
```

```text
 ────────────┬────────────┬─────────┬────────┬────────
  Connection   Driver       TLS      Status   Time
 ────────────┼────────────┼─────────┼────────┼────────
  local        SQLite       —        OK       1ms
  staging      MySQL        require  OK       38ms
  prod         PostgreSQL   default  OK       55ms
 ────────────┴────────────┴─────────┴────────┴────────

All 3 connections OK.
```

The `TLS` column shows the same modes as `connection:list`. SQLite and dump connections show `—`. With `-v`, a `Cipher` column shows the negotiated cipher for each successful network connection.

## Update a connection

```bash
clonio connection:update production
```

Secrets display as masked values. Press Enter to keep an existing secret or enter a new value to replace it.

Transport security is preselected with the stored mode. Certificate path prompts show the stored path: press Enter to keep it, type `none` to remove it, or enter a new path.

With `--no-interaction` and no name, the command only works when exactly one connection exists. With several connections it fails with exit code `2`; pass the name explicitly in scripts.

## Delete a connection

```bash
clonio connection:delete old-staging
```

Deleting a connection removes it from `clonio.json`. It does not change committed `.cloning.yaml` files that reference the connection name.

The command asks for confirmation before deleting. Non-interactively (`--no-interaction`), nothing is deleted without `--force`. Without a name and with several connections, it fails with exit code `2` instead of picking one:

```bash
clonio connection:delete old-staging --force --no-interaction
```

## Security notes

- Do not commit `.env`.
- Do not commit `clonio.json`.
- Store `APP_KEY` as a CI secret for pipeline usage.
- Regenerating `APP_KEY` with `clonio init --force` makes existing encrypted passwords unreadable.
- `clonio.json` stores certificate and key **paths**, never their contents. Keep private key files outside the project or in `.gitignore`, and restrict them with `chmod 600`.
