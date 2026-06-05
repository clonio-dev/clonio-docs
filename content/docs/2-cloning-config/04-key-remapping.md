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

## Large databases

For large mappings, use file-based mapping storage:

```bash
clonio cloning:run production.cloning.yaml --target staging --file-based
```

If memory is acceptable and PHP's memory limit is the blocker:

```bash
clonio cloning:run production.cloning.yaml --target staging --no-memory-limit
```
