---
title: Anonymization Strategies
excerpt: Choose how Clonio transforms individual columns during a clone.
---

# Anonymization Strategies

Clonio applies transformations per column. Columns not listed in `.cloning.yaml` are copied unchanged.

## `keep`

Copy the value unchanged. This is the implicit default for unlisted columns.

```yaml
status:
  strategy: keep
```

## `fake`

Generate realistic synthetic data with FakerPHP.

```yaml
email:
  strategy: fake
  faker_method: safeEmail
  faker_arguments: []
```

Examples:

```yaml
first_name:
  strategy: fake
  faker_method: firstName
  faker_arguments: []

date_of_birth:
  strategy: fake
  faker_method: date
  faker_arguments: ["Y-m-d"]
```

## `hash`

Replace values with a one-way hash. Hashing is useful when equal input values should remain joinable inside one run.

```yaml
employee_number:
  strategy: hash
  algorithm: sha256
```

Hashing is pseudonymisation, not full anonymization. Prefer `fake`, `null`, or key remapping when linkage must be impossible.

## `mask`

Reveal a small prefix and mask the rest.

```yaml
phone:
  strategy: mask
  visible_chars: 4
  mask_char: "*"
  preserve_format: true
```

## `null`

Set the column to `NULL`. The target column must allow null values.

```yaml
notes:
  strategy: "null"
```

Always quote `"null"`. Unquoted, YAML reads `strategy: null` as an empty value, not as the `null` strategy, and validation fails with a hint to add the quotes.

## `exclude`

Leave the column out of the transfer. Clonio does not read it from the source and does not write it to the target, so the target column gets its default value or `NULL`.

```yaml
internal_note:
  strategy: exclude
```

Use it for columns whose data must never leave the source, or for columns the target computes itself. The target column must be nullable or have a default, otherwise inserts fail. Clonio prints a note when an excluded column is `NOT NULL` without a default on the target.

Generated columns are left out automatically, see [Generated columns](../3-running-clones/02-dry-runs-and-schema-sync.md#generated-columns).

## `static`

Use one fixed value for every row.

```yaml
environment_tag:
  strategy: static
  value: "dev-imported"
```

## Review responsibility

PII auto-detection is a starting point. You are responsible for reviewing generated rules before cloning production data.
