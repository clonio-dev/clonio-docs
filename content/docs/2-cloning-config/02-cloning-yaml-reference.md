---
title: .cloning.yaml Reference
excerpt: Understand the Clonio cloning configuration file format.
---

# `.cloning.yaml` Reference

A `.cloning.yaml` file describes how Clonio transfers and anonymizes one source database. It is safe to commit because it stores a connection name, not credentials.

```yaml
version: "1"
connection: production

options:
  chunk_size: 1000
  enforce_column_types: false
  drop_unknown_tables: false
  drop_extra_columns: false
  disable_foreign_key_checks: true
  faker_locale: en_US

tables:
  users:
    rows:
      strategy: full
      clear: delete
    columns:
      email:
        strategy: fake
        faker_method: safeEmail
        faker_arguments: []
```

## Top-level fields

| Field | Required | Description |
|---|---:|---|
| `version` | yes | Schema version. Must be `"1"`. |
| `connection` | yes | Source connection name from `clonio.json`. |
| `options` | yes | Global transfer and schema settings. |
| `tables` | yes | Per-table transfer rules. |

## Options

| Field | Description |
|---|---|
| `chunk_size` | Rows fetched and inserted per batch. |
| `enforce_column_types` | Add source columns missing from the target. |
| `drop_unknown_tables` | Drop target tables absent from the source. |
| `drop_extra_columns` | Drop target columns absent from the source. Destructive. |
| `disable_foreign_key_checks` | Disable target FK checks during transfer where supported. |
| `faker_locale` | Faker locale for `fake` strategies, such as `en_US` or `de_DE`. |

## Row strategies

| Strategy | Description |
|---|---|
| `full` | Copy all rows. |
| `first` | Copy the first `limit` rows ordered by `sort_by` or primary key. |
| `last` | Copy the last `limit` rows ordered by `sort_by` or primary key. |

`rows.clear` can be `false`, `delete`, or `truncate`.

## Columns

Only list columns that need transformation. Unlisted columns are kept as-is.

```yaml
columns:
  email:
    strategy: fake
    faker_method: safeEmail
    faker_arguments: []
```

See [Anonymization Strategies](03-anonymization-strategies.md) for strategy details.
