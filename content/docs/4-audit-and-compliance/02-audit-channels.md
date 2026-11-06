---
title: Audit Channels
excerpt: Send audit logs and process logs to local storage, S3, email, Slack, Teams, ntfy, or channel stacks.
---

# Audit Channels

Audit channels define where Clonio sends audit logs and process logs after a run.

## Add a channel

```bash
clonio audit:add logs --type=local --local-path=./clonio-logs/{year}/{month} --enable
```

Supported channel types:

| Type | Value |
|---|---|
| Local filesystem | `local` |
| S3-compatible storage | `s3` |
| Email via SMTP | `email` |
| Microsoft Teams | `ms_teams` |
| Slack | `slack` |
| ntfy | `ntfy` |
| Fan-out stack | `stack` |

## Use a channel for one run

```bash
clonio cloning:run production.cloning.yaml --target staging --audit-channel=logs
```

## Manage channels

```bash
clonio audit:list
clonio audit:update logs
clonio audit:delete logs
```

## Secrets

Secrets such as webhook URLs, SMTP passwords, S3 secret keys and ntfy tokens are stored in one of two forms:

| Stored value | Meaning |
|---|---|
| `env:NAME` | Read from the environment variable `NAME` when the audit log is delivered; never written to disk. **Default.** |
| `encrypted:<payload>` | Encrypted with `CLONIO_KEY` and stored in `clonio.json`. |

For each secret, `audit:add` and `audit:update` first ask how to get it. The default is an environment variable named `CLONIO_AUDIT_<CHANNEL>_<FIELD>`, for example `CLONIO_AUDIT_S3_BACKUP_SECRET_KEY`. Clonio warns if the variable is not set yet; delivery fails until it is.

```bash
clonio audit:add slack-alerts --type=slack --webhook-url=env:SLACK_AUDIT_WEBHOOK
```

`--webhook-url=env:NAME` (and the other secret flags) stores the reference. Any other flag value is encrypted, and Clonio warns that it may end up in shell history.

An encrypted secret is only as safe as `CLONIO_KEY`. For production transfers, deliver audit logs to a channel outside the CI runner. See [Security and Deployment](04-security-and-deployment.md).
