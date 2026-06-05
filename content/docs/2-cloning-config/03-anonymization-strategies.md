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

## `static`

Use one fixed value for every row.

```yaml
environment_tag:
  strategy: static
  value: "dev-imported"
```

## Review responsibility

PII auto-detection is a starting point. You are responsible for reviewing generated rules before cloning production data.
