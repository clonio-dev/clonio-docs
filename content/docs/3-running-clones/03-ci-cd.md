---
title: CI/CD Usage
excerpt: Run Clonio from GitHub Actions, GitLab CI, Composer, or Docker.
---

# CI/CD Usage

Clonio CLI is designed for pipelines. Store database passwords as `env:NAME` references in `clonio.json`, keep the values and `CLONIO_KEY` in the CI secret store, provide database access from the runner, and run with `--ci`.

Pass the secrets only to the step that runs the clone. A step that registers connections with `env:` references stores no secrets and needs none. For the full deployment model (ephemeral runners, read-only replica user, external audit channel), see [Security and Deployment](../4-audit-and-compliance/04-security-and-deployment.md).

## GitHub Actions with Composer

```yaml
- name: Install dependencies
  run: composer install --no-interaction

- name: Clone staging database
  run: vendor/bin/clonio cloning:run production.cloning.yaml --target staging --ci
  env:
    CLONIO_KEY: ${{ secrets.CLONIO_KEY }}
    CLONIO_PRODUCTION_PASSWORD: ${{ secrets.CLONIO_PRODUCTION_PASSWORD }}
    CLONIO_STAGING_PASSWORD: ${{ secrets.CLONIO_STAGING_PASSWORD }}
```

Here `clonio.json` stores `env:CLONIO_PRODUCTION_PASSWORD` and `env:CLONIO_STAGING_PASSWORD`. `CLONIO_KEY` signs the audit log.

## GitLab CI with Composer

```yaml
cloning:
  image: php:8.5-cli
  before_script:
    - composer install --no-interaction
  script:
    - vendor/bin/clonio cloning:run production.cloning.yaml --target staging --ci
```

Define `CLONIO_KEY`, `CLONIO_PRODUCTION_PASSWORD` and `CLONIO_STAGING_PASSWORD` as masked, protected CI/CD variables; GitLab passes them to the job as environment variables. Project variables are visible to every job in the project, so scope them to the cloning job's environment where possible.

## Encrypted database connections

Store the database CA certificate as a CI secret, write it to a file, and point the connection at it:

```yaml
- name: Write database CA
  run: printf '%s\n' "$DB_CA_PEM" > db-ca.pem
  env:
    DB_CA_PEM: ${{ secrets.DB_CA_PEM }}

- name: Register connection (reference only, no secret needed)
  run: |
    vendor/bin/clonio connection:add production --type=mysql \
      --host=db.example.com --port=3306 --database=app \
      --username=clonio_ro --password=env:CLONIO_PRODUCTION_PASSWORD \
      --ssl-mode=verify --ssl-ca=db-ca.pem --production --no-interaction

- name: Clone staging database
  run: vendor/bin/clonio cloning:run production.cloning.yaml --target staging --ci
  env:
    CLONIO_KEY: ${{ secrets.CLONIO_KEY }}
    CLONIO_PRODUCTION_PASSWORD: ${{ secrets.CLONIO_PRODUCTION_PASSWORD }}
    CLONIO_STAGING_PASSWORD: ${{ secrets.CLONIO_STAGING_PASSWORD }}
```

`--password=env:CLONIO_PRODUCTION_PASSWORD` stores only the reference, so the register step gets no secrets. Clonio reads the password when the clone step connects. Do not pass `--password="$DB_PASSWORD"`: any value other than `env:NAME` is stored encrypted in `clonio.json`.

Relative certificate paths resolve against the working directory, so write the file where `clonio.json` expects it. If the CA isn't available in the pipeline, `--ssl-mode=require` encrypts without verifying the server. See [Transport Security](../1-connections/04-transport-security.md).

## Docker

```yaml
- name: Run Clonio
  run: |
    docker run --rm \
      -e CLONIO_KEY -e CLONIO_PRODUCTION_PASSWORD -e CLONIO_STAGING_PASSWORD \
      -v "${{ github.workspace }}":/workspace \
      ghcr.io/clonio-dev/clonio:1.2.3 \
      cloning:run production.cloning.yaml --target staging --ci
  env:
    CLONIO_KEY: ${{ secrets.CLONIO_KEY }}
    CLONIO_PRODUCTION_PASSWORD: ${{ secrets.CLONIO_PRODUCTION_PASSWORD }}
    CLONIO_STAGING_PASSWORD: ${{ secrets.CLONIO_STAGING_PASSWORD }}
```

`-e NAME` without a value passes the variable from the step's environment into the container, so the secrets do not appear on the command line.

Pin exact Docker tags in CI. Use `latest` only for interactive local use.

## Optional pipeline step

If a clone should not fail the whole pipeline:

```bash
clonio cloning:run production.cloning.yaml --target staging --ci --allow-failure
```
