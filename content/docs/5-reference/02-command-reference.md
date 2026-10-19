---
title: Command Reference
excerpt: Compact overview of all Clonio CLI commands, with links to the full per-command reference.
---

# Command Reference

Every command links to its full reference page with all arguments, options, exit codes and examples. Run `clonio help <command>` for the built-in help.

## Project setup

| Command | Purpose |
|---|---|
| [`clonio init`](../6-commands/01-init.md) | Ensure `APP_KEY` exists and create `clonio.json` with default audit channels. |
| [`clonio update [version]`](../6-commands/02-update.md) | Update standalone binary or PHAR installations. |
| [`clonio about`](../6-commands/03-about.md) | Show a short product description. |

## Connections

| Command | Purpose |
|---|---|
| [`clonio connection:add`](../6-commands/04-connection-add.md) | Add a database or [dump](../1-connections/03-sql-dump-connections.md) connection, including [transport security](../1-connections/04-transport-security.md) (TLS). |
| [`clonio connection:list`](../6-commands/05-connection-list.md) | List configured connections and their TLS mode. |
| [`clonio connection:test`](../6-commands/06-connection-test.md) | Test database connectivity; `-v` shows the negotiated TLS cipher. |
| [`clonio connection:update`](../6-commands/07-connection-update.md) | Update connection settings, secrets or transport security. |
| [`clonio connection:delete`](../6-commands/08-connection-delete.md) | Remove a connection. |

## Cloning

| Command | Purpose |
|---|---|
| [`clonio cloning:dump`](../6-commands/09-cloning-dump.md) | Generate a `.cloning.yaml` from a source database. |
| [`clonio cloning:run`](../6-commands/10-cloning-run.md) | Execute a transfer and apply transformations. |
| [`clonio cloning:table:edit`](../6-commands/11-cloning-table-edit.md) | Edit a table strategy in a `.cloning.yaml`. |
| [`clonio cloning:column:edit`](../6-commands/12-cloning-column-edit.md) | Edit a column strategy in a `.cloning.yaml`. |
| [`clonio cloning:verify-audit`](../6-commands/13-cloning-verify-audit.md) | Verify a signed audit artefact. |

## PII matchers

| Command | Purpose |
|---|---|
| [`clonio matchers:init`](../6-commands/14-matchers.md) | Export the baseline matchers to a customizable `clonio.pii-matchers.yaml`. |
| [`clonio matchers:update`](../6-commands/14-matchers.md) | Add new baseline matchers to an existing file after upgrading. |
| [`clonio matchers:list`](../6-commands/14-matchers.md) | List the effective matcher set. |
| [`clonio matchers:check <column> [value]`](../6-commands/14-matchers.md) | Test how one column name is classified. |

## Audit channels

| Command | Purpose |
|---|---|
| [`clonio audit:add`](../6-commands/15-audit.md) | Add an audit delivery channel. |
| [`clonio audit:list`](../6-commands/15-audit.md) | List audit channels. |
| [`clonio audit:update`](../6-commands/15-audit.md) | Update a channel. |
| [`clonio audit:delete`](../6-commands/15-audit.md) | Delete a channel. |

## Testing

| Command | Purpose |
|---|---|
| [`clonio fake:data <connection> [rows]`](../6-commands/16-fake-data.md) | Seed a connection with fake data for testing and benchmarks. |
