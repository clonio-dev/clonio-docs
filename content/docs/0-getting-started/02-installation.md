---
title: Installation
excerpt: Install Clonio CLI as a standalone binary, Composer dev dependency, Docker image, or PHAR.
---

# Installation

Clonio CLI can run as a standalone binary, Composer dev dependency, Docker image, or PHAR. Choose the method that fits your workflow.

## Standalone binary

Download the latest release from GitHub:

```bash
curl -L https://github.com/clonio-dev/clonio-cli/releases/latest/download/clonio-macos-aarch64 -o clonio
chmod +x clonio
sudo mv clonio /usr/local/bin/clonio
clonio --version
```

Available release assets include platform-specific binaries and `clonio.phar`. On macOS, if Gatekeeper blocks the downloaded binary, remove the quarantine flag before moving it:

```bash
xattr -d com.apple.quarantine clonio
```

## Composer dev dependency

Install Clonio in a PHP project:

```bash
composer require --dev clonio-dev/clonio-cli
vendor/bin/clonio --version
```

This is useful when your CI pipeline already runs `composer install` and you want a version pinned by `composer.lock`.

```yaml
- name: Clone staging database
  run: vendor/bin/clonio cloning:run production.cloning.yaml --target staging --ci
  env:
    APP_KEY: ${{ secrets.CLONIO_APP_KEY }}
```

## Docker image

Clonio is published as a multi-arch image on GitHub Container Registry:

```bash
docker run --rm -v "$(pwd)":/workspace \
  ghcr.io/clonio-dev/clonio:latest --version
```

Run commands against files in your current directory:

```bash
docker run --rm --env-file .env -v "$(pwd)":/workspace \
  ghcr.io/clonio-dev/clonio:latest cloning:run production.cloning.yaml --target local-dev
```

For CI, pin an exact tag instead of `latest`:

```bash
ghcr.io/clonio-dev/clonio:1.2.3
```

## PHAR

Download `clonio.phar` from the latest release and run it with PHP 8.5 or newer:

```bash
php clonio.phar --version
```

## Requirements

- PHP 8.5 or newer for Composer and PHAR usage.
- Database network access from the machine, container, or CI runner that executes Clonio.
- `APP_KEY` for encrypting and decrypting stored secrets.

## Update

Standalone binary and PHAR installations can use:

```bash
clonio update
```

Composer installations update through Composer:

```bash
composer update clonio-dev/clonio-cli
```
