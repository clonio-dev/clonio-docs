---
title: PII Matchers
excerpt: Customize how cloning:dump detects sensitive columns.
---

# PII Matchers

`cloning:dump` uses PII matchers to suggest transformations for sensitive columns. Matchers are based on column names and are meant to accelerate review, not replace it.

## Export matchers

```bash
clonio matchers:init
```

This writes `clonio.pii-matchers.yaml` so you can customize patterns and strategies.

## List active matchers

```bash
clonio matchers:list
```

## Check one column

```bash
clonio matchers:check email_address
clonio matchers:check iban
clonio matchers:check api_token
```

## Typical categories

- personal identity: names, birth dates, gender
- contact data: email, phone, address, city, postcode
- financial data: IBAN, bank account, credit-card-like fields
- authentication data: passwords, secrets, tokens, API keys
- network data: IP addresses, MAC addresses

Always review generated `.cloning.yaml` files before running against production data.
