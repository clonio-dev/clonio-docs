---
title: CI/CD Usage
excerpt: Run Clonio from GitHub Actions, GitLab CI, Composer, or Docker.
---

# CI/CD Usage

Clonio CLI is designed for pipelines. Store `APP_KEY` as a CI secret, provide database access from the runner, and run with `--ci`.

## GitHub Actions with Composer

```yaml
- name: Install dependencies
  run: composer install --no-interaction

- name: Clone staging database
  run: vendor/bin/clonio cloning:run production.cloning.yaml --target staging --ci
  env:
    APP_KEY: ${{ secrets.CLONIO_APP_KEY }}
```

## GitLab CI with Composer

```yaml
cloning:
  image: php:8.5-cli
  before_script:
    - composer install --no-interaction
  script:
    - vendor/bin/clonio cloning:run production.cloning.yaml --target staging --ci
  variables:
    APP_KEY: $CLONIO_APP_KEY
```

## Docker

```yaml
- name: Run Clonio
  run: |
    docker run --rm \
      -e APP_KEY="${{ secrets.CLONIO_APP_KEY }}" \
      -v "${{ github.workspace }}":/workspace \
      ghcr.io/clonio-dev/clonio:1.2.3 \
      cloning:run production.cloning.yaml --target staging --ci
```

Pin exact Docker tags in CI. Use `latest` only for interactive local use.

## Optional pipeline step

If a clone should not fail the whole pipeline:

```bash
clonio cloning:run production.cloning.yaml --target staging --ci --allow-failure
```
