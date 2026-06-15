---
title: Command Reference
excerpt: Compact overview of common Clonio CLI commands.
---

# Command Reference

## Project setup

| Command | Purpose |
|---|---|
| `clonio about` | Show a short product description. |
| `clonio init` | Ensure `APP_KEY` exists. |
| `clonio update` | Update standalone binary or PHAR installations. |

## Connections

| Command | Purpose |
|---|---|
| `clonio connection:add` | Add a database or [dump](../1-connections/03-sql-dump-connections.md) connection. |
| `clonio connection:list` | List configured connections. |
| `clonio connection:test` | Test database connectivity. |
| `clonio connection:update` | Update connection settings or secrets. |
| `clonio connection:delete` | Remove a connection. |

## Cloning

| Command | Purpose |
|---|---|
| `clonio cloning:dump` | Generate a `.cloning.yaml` from a source database. |
| `clonio cloning:run` | Execute a transfer and apply transformations. |
| `clonio cloning:verify-audit` | Verify a signed audit artefact. |
| `clonio cloning:table-edit` | Edit table configuration interactively. |
| `clonio cloning:column-edit` | Edit column configuration interactively. |

## PII and fake data

| Command | Purpose |
|---|---|
| `clonio matchers:init` | Export customizable PII matcher config. |
| `clonio matchers:list` | List active matchers. |
| `clonio matchers:check` | Test one column name. |
| `clonio fake-data` | Inspect available fake data methods. |

## Audit channels

| Command | Purpose |
|---|---|
| `clonio audit:add` | Add an audit delivery channel. |
| `clonio audit:list` | List audit channels. |
| `clonio audit:update` | Update a channel. |
| `clonio audit:delete` | Delete a channel. |
