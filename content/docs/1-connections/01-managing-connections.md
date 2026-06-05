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
  --production
```

## List connections

```bash
clonio connection:list
```

Use this to confirm the names you will reference from `.cloning.yaml` and `--target`.

## Test a connection

```bash
clonio connection:test production
```

Test both source and target before running `cloning:dump` or `cloning:run`.

## Update a connection

```bash
clonio connection:update production
```

Secrets display as masked values. Press Enter to keep an existing secret or enter a new value to replace it.

## Delete a connection

```bash
clonio connection:delete old-staging
```

Deleting a connection removes it from `clonio.json`. It does not change committed `.cloning.yaml` files that reference the connection name.

## Security notes

- Do not commit `.env`.
- Do not commit `clonio.json`.
- Store `APP_KEY` as a CI secret for pipeline usage.
- Regenerating `APP_KEY` with `clonio init --force` makes existing encrypted passwords unreadable.
