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

Secrets such as webhook URLs, SMTP passwords, and S3 secret keys are stored encrypted in `clonio.json`.
