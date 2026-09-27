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

## Encrypted database connections

Store the database CA certificate as a CI secret, write it to a file, and point the connection at it:

```yaml
- name: Write database CA
  run: printf '%s\n' "$DB_CA_PEM" > db-ca.pem
  env:
    DB_CA_PEM: ${{ secrets.DB_CA_PEM }}

- name: Register connection
  run: |
    vendor/bin/clonio connection:add production --type=mysql \
      --host=db.example.com --port=3306 --database=app \
      --username=clonio --password="$DB_PASSWORD" \
      --ssl-mode=verify --ssl-ca=db-ca.pem --production --no-interaction
  env:
    APP_KEY: ${{ secrets.CLONIO_APP_KEY }}
    DB_PASSWORD: ${{ secrets.DB_PASSWORD }}
```

Relative certificate paths resolve against the working directory, so write the file where `clonio.json` expects it. If the CA isn't available in the pipeline, `--ssl-mode=require` encrypts without verifying the server. See [Transport Security](../1-connections/04-transport-security.md).

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
