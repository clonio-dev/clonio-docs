---
title: Key Remapping
excerpt: Replace production primary keys and rewrite foreign keys consistently.
---

# Key Remapping

Replacing names and emails is not always enough. A production primary key can still identify a person if the same ID appears in logs, URLs, exports, support tickets, or external systems.

Key remapping replaces primary-key values before they reach the target and rewrites declared foreign keys to the new values.

## Example

```yaml
tables:
  users:
    rows:
      strategy: full
    columns:
      id:
        strategy: remapping
        arguments:
          - use: random_integer
          - foreign_keys:
              - table: orders
                column: user_id
              - table: employees
                column: manager_id
                self_referential: true
      email:
        strategy: fake
        faker_method: safeEmail
        faker_arguments: []
```

In this example, `users.id` receives new random values. `orders.user_id` and `employees.manager_id` are rewritten to point to the new IDs.

## Why it matters

Key remapping helps keep the relational graph intact while reducing the risk of correlating target records back to production identifiers.

## Polymorphic relations

A polymorphic column, such as Laravel's `addressable_type` + `addressable_id`, points at a different table per row. List it under each remapped table it can point at, and name the type column and the type value of that table:

```yaml
users:
  columns:
    id:
      strategy: remapping
      arguments:
        - use: random_integer
        - foreign_keys:
            - table: addresses
              column: addressable_id
              type_column: addressable_type
              type_value: App\Models\User   # or the morph alias, e.g. user
companies:
  columns:
    id:
      strategy: remapping
      arguments:
        - use: random_integer
        - foreign_keys:
            - table: addresses
              column: addressable_id
              type_column: addressable_type
              type_value: App\Models\Company
```

Each address row is rewritten with the mapping of the table its `addressable_type` names. `type_value` is the value stored in the type column: the model class or its morph alias. Rows with a type that no entry names keep their source value.

`cloning:dump` and `cloning:column:edit --strategy=remapping` add these entries for `<name>_type` + `<name>_id` column pairs, see [cloning:dump](../6-commands/09-cloning-dump.md#polymorphic-relations).

`cloning:run` stops with exit code `4` when the same column is listed under more than one remapped table without `type_column`, when two entries share a `type_value`, or when the type column does not exist.

## Disabling remapping

Remapping can be turned off without removing its definition — persistently in the YAML:

```yaml
options:
  remap_keys: false
```

or for a single run:

```bash
clonio cloning:run production.cloning.yaml --target staging --no-remap-keys
```

`--skip-remapping-keys` is an alias of `--no-remap-keys` and keeps working in existing scripts.

`--remap-keys` re-enables remapping for one run when the YAML sets `remap_keys: false`. `cloning:dump --no-remap-keys` writes `remap_keys: false` into a new config.

This is useful when the schema has many cross-references that are not declared as foreign keys, so remapping would leave them pointing at the old IDs.

> **Warning:** With remapping disabled, primary and foreign key values are copied from production unchanged. If those IDs can identify people (see [Why it matters](#why-it-matters)), the target is less anonymized. `cloning:run` prints a notice whenever configured remapping is skipped.

## Large databases

For large mappings, use file-based mapping storage:

```bash
clonio cloning:run production.cloning.yaml --target staging --file-based
```

If memory is acceptable and PHP's memory limit is the blocker:

```bash
clonio cloning:run production.cloning.yaml --target staging --no-memory-limit
```
