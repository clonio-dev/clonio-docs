---
title: Local Development
excerpt: Build, test, and lint Clonio CLI from source, with a Docker-based dev environment or a local PHP toolchain.
---

# Local Development

This page is for contributors working on the Clonio CLI source code from [clonio-dev/clonio-cli](https://github.com/clonio-dev/clonio-cli). To run Clonio against your own databases, see [Installation](../0-getting-started/02-installation.md) or the published [Docker image](03-docker.md).

You can work in two ways:

- **Docker dev environment**: no PHP on your machine, only Docker.
- **Local toolchain**: PHP 8.5 and Composer installed on your machine.

Both run the same `composer test` and `composer lint` scripts.

## Docker dev environment

### Requirements

- Docker with Compose v2 (`docker compose`, not `docker-compose`).
- `make` (optional). Every target has a plain `docker compose` equivalent.

You do not need PHP, Composer, or any PHP extensions on the host.

### The dev image

The dev environment is the `dev` stage of the repository's `Dockerfile`, wired up in `compose.yaml` as a single `php` service:

- `php:8.5-cli-alpine` with the **same PHP extensions as the published image**, plus Composer, git, and Xdebug.
- The repository is bind-mounted at `/app`, so changes on the host are visible in the container immediately. Source code is not copied into the image.
- A named volume caches Composer downloads between runs.
- `memory_limit` is unlimited (`-1`), because PHPStan and type coverage exceed PHP's 128M default. CI runs unlimited as well.

The dev image (`clonio:dev`) is for working on Clonio. It is not published and is not the image you run in production or CI pipelines.

### Get started

```bash
git clone https://github.com/clonio-dev/clonio-cli.git
cd clonio-cli
make dev-build
make dev-install
make dev-test
```

### Make targets

| Make target | Raw command (for example on Windows without `make`) | What it does |
|---|---|---|
| `make dev-build` | `docker compose build php` | Build the dev image `clonio:dev`. |
| `make dev-install` | `docker compose run --rm php composer install` | Install Composer dependencies into `vendor/`. |
| `make dev-shell` | `docker compose run --rm php sh` | Open a shell in the dev container. |
| `make dev-test` | `docker compose run --rm -e XDEBUG_MODE=coverage php composer test` | Run the full test suite with coverage. |
| `make dev-lint` | `docker compose run --rm php composer lint` | Run Rector and Pint in fix mode. Modifies files in place. |

`make help` lists all targets.

### Run other commands

Any command runs the same way. Prefix it with `docker compose run --rm php`:

```bash
# Run the CLI from source
docker compose run --rm php php clonio connection:test

# Run a single test file
docker compose run --rm php ./vendor/bin/pest tests/Unit/BinaryResolverTest.php
```

### File ownership

The container entrypoint detects the owner of the mounted repository and runs your command as that user. Files created in the container, such as `vendor/`, caches, and coverage reports, belong to you on the host:

| Host setup | Command runs as |
|---|---|
| Linux, rootful Docker | Your host uid/gid, for example `1000:1000`. |
| macOS (Docker Desktop, OrbStack) | Your host uid/gid, for example `501:20`. |
| Windows, checkout in the WSL2 filesystem | Your WSL user, usually `1000:1000`. |
| Rootless Docker or Podman, Windows drive mounts | `root`, which maps back to your host user. |

### Always use `run --rm`, not `exec`

Use `docker compose run --rm php ...` for every command. `docker compose exec` bypasses the entrypoint, so the command runs as root and creates root-owned files in your checkout. There is no long-running container to `exec` into anyway.

### Xdebug

Xdebug is installed but off by default (`XDEBUG_MODE=off`) so that tests and PHPStan stay fast.

- `make dev-test` switches it to coverage mode.
- For step debugging, pass the mode yourself:

```bash
docker compose run --rm -e XDEBUG_MODE=debug php php clonio connection:list
```

### Windows

Keep the checkout inside the WSL2 filesystem (for example `~/code/clonio-cli`), not on a Windows drive under `/mnt/c/...`. Bind mounts from Windows drives are slow.

## Local toolchain

Requirements:

- PHP 8.5
- Composer

```bash
composer install
php clonio <command>
```

### Tests

```bash
composer test
```

`composer test` runs every stage. You can also run each stage on its own:

| Command | What it does |
|---|---|
| `composer test:unit` | Pest with coverage (minimum 95%). |
| `composer test:type-coverage` | Type coverage check (minimum 99%). |
| `composer test:types` | PHPStan static analysis (level max). |
| `composer test:lint` | Pint and Rector in dry-run mode. |

Coverage needs a driver such as Xdebug or pcov.

### Lint and auto-fix

```bash
composer lint
```

Runs Rector and Pint in fix mode. Modifies files in place.

### Build a PHAR

```bash
composer build
```

Writes the PHAR to `builds/clonio`. The embedded version comes from the latest git tag. Without a tag it falls back to `UNRELEASED`.
