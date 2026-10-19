---
title: Audit Logs
excerpt: Keep signed evidence of every Clonio run.
---

# Audit Logs

Clonio can produce audit artefacts for each run. These logs document what was executed, when it ran, which source and target were used, which configuration was applied, and whether the run succeeded.

Signed audit logs help you prove that the transferred dataset was processed through a reviewed configuration instead of an ad-hoc copy script.

## Notes

The audit log has a **Notes** section when a run left columns out of the transfer. It lists, per table, generated columns that were not copied, generation expressions that were not recreated on the target, and columns excluded with the `exclude` strategy. The section is missing when there is nothing to report.

## What to keep

- Signed audit artefact for compliance review.
- Structured process log for debugging and run history.
- The committed `.cloning.yaml` version used for the run.

## Verification

Use the CLI verification command when you need to validate audit integrity offline:

```bash
clonio cloning:verify-audit path/to/audit.html
```

Keep audit outputs outside your source repository unless your compliance process explicitly requires committed artefacts.
