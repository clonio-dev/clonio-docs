---
title: Docker
excerpt: Run Clonio CLI from the GitHub Container Registry image.
---

# Docker

Clonio is published as a multi-arch Docker image:

```text
ghcr.io/clonio-dev/clonio
```

Supported platforms:

- `linux/amd64`
- `linux/arm64`

## Quick start

```bash
docker run --rm -v "$(pwd)":/workspace \
  ghcr.io/clonio-dev/clonio:latest --version
```

The image uses `/workspace` as the working directory. Mount your project root there so `.env`, `clonio.json`, and `.cloning.yaml` resolve as expected.

## Run with environment file

```bash
docker run --rm \
  --env-file .env \
  -v "$(pwd)":/workspace \
  ghcr.io/clonio-dev/clonio:latest cloning:run production.cloning.yaml --target local-dev
```

## Avoid root-owned output files on Linux

```bash
docker run --rm \
  --user "$(id -u):$(id -g)" \
  -v "$(pwd)":/workspace \
  ghcr.io/clonio-dev/clonio:latest cloning:run production.cloning.yaml --target local-dev
```

## Tags

| Tag | Use |
|---|---|
| `latest` | Interactive local use. |
| `1` | Track latest stable major. |
| `1.2` | Track latest stable minor. |
| `1.2.3` | Exact immutable CI version. |

Pin exact tags in CI.
