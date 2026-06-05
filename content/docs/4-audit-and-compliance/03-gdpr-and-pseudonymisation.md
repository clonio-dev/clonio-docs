---
title: GDPR and Pseudonymisation
excerpt: Understand anonymization limits, pseudonymisation, and why key remapping matters.
---

# GDPR and Pseudonymisation

Clonio helps reduce risk when moving production-like data into non-production environments, but it does not remove your responsibility to review transformation rules and operate within your compliance requirements.

## Anonymization is configuration-dependent

Generated PII rules are a starting point. You must review `.cloning.yaml` and make sure sensitive columns use suitable transformations.

Examples:

- Use `fake` for emails, names, addresses, and other data that should not remain linkable.
- Use `null` for optional values that should not be present in test.
- Use `hash` only when stable linkage is needed and pseudonymisation is acceptable.
- Use key remapping for production identifiers.

## Why IDs matter

Replacing names and emails alone may not be enough. A primary key such as `user_id = 4821` can still identify a person when it appears in logs, URLs, exports, or other systems.

Key remapping replaces primary keys and rewrites foreign keys so the target dataset remains relationally consistent without preserving production identifiers.

## Infrastructure boundary

Clonio runs inside your infrastructure. It connects directly from your machine, container, or CI runner to your databases. There is no external Clonio cloud service involved in a CLI run.
