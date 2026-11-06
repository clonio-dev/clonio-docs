---
title: Managing Connections
excerpt: Add, test, update, list, and delete database connections for Clonio CLI.
---

# Managing Connections

Clonio stores database connections in `clonio.json` in the current working directory. Passwords and other secrets are stored as `env:NAME` references to environment variables by default, so they are never written to disk. Alternatively, a secret can be stored encrypted with `CLONIO_KEY` from your environment or `.env` file. See [Secrets](#secrets) and [Security and Deployment](../4-audit-and-compliance/04-security-and-deployment.md).

Run commands from the project directory that owns the cloning configuration.

## Initialize encryption

```bash
clonio init
```

This ensures `CLONIO_KEY` exists (projects set up with earlier versions can keep using `APP_KEY` as a fallback). Clonio uses it to encrypt secrets you choose to store in `clonio.json` and to sign audit logs. If `.gitignore` already exists, Clonio adds `.env` and `clonio.json` when missing.

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
- username
- how to get the password: from an environment variable (default, stores `env:CLONIO_<NAME>_PASSWORD` or another name you enter) or entered now and stored encrypted
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
  --username=clonio_ro \
  --password=env:CLONIO_PRODUCTION_PASSWORD \
  --ssl-mode=verify --ssl-ca=certs/production-ca.pem \
  --production
```

`--password=env:CLONIO_PRODUCTION_PASSWORD` stores only the reference. Clonio reads the password from `CLONIO_PRODUCTION_PASSWORD` each time it connects. Without interaction and without `--password`, a network connection stores `env:CLONIO_<NAME>_PASSWORD`.

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

The stored password is never decrypted or shown. Clonio asks how to get the password: keep the current one (default), read it from an environment variable, or enter it now and store it encrypted.

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

## Secrets

A stored password has one of two forms:

| Stored value | Meaning |
|---|---|
| `env:CLONIO_PRODUCTION_PASSWORD` | Read from the environment variable `CLONIO_PRODUCTION_PASSWORD` each time Clonio connects. Never written to disk. **Default.** |
| `encrypted:<payload>` | Encrypted with `CLONIO_KEY` and stored in `clonio.json`. |

An encrypted password is only as safe as the key, and the key usually sits in `.env` next to `clonio.json`: anyone who can read both files can decrypt it. Prefer environment references and provide the values from your secret store.

If a referenced variable is not set, `connection:add` warns but saves the reference; `connection:test` and `cloning:run` fail with `environment variable … is not set` until you set it.

## Security notes

- Prefer `env:` references for all secrets. See [Security and Deployment](../4-audit-and-compliance/04-security-and-deployment.md).
- Do not commit `.env`.
- Do not commit `clonio.json`.
- Store `CLONIO_KEY` as a CI secret for pipeline usage. It also signs audit logs.
- Regenerating the key with `clonio init --force` makes existing encrypted passwords unreadable. `env:` references are not affected. To replace the key and keep the passwords, run [`clonio key:rotate`](../6-commands/17-key-rotate.md).
- `clonio.json` stores certificate and key **paths**, never their contents. Keep private key files outside the project or in `.gitignore`, and restrict them with `chmod 600`.
