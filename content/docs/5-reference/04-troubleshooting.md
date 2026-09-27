---
title: Troubleshooting
excerpt: Common Clonio CLI setup, connection, Docker, APP_KEY, and schema issues.
---

# Troubleshooting

## `APP_KEY` is missing

Run:

```bash
clonio init
```

In CI, set `APP_KEY` as a secret environment variable. Do not generate a new key for every run if you need to decrypt existing `clonio.json` secrets.

## Encrypted passwords cannot be decrypted

The `APP_KEY` changed. Restore the original key or re-enter passwords:

```bash
clonio connection:update production
```

## Docker cannot reach localhost database

Inside Docker, `localhost` is the container. On Linux, add the host gateway:

```bash
docker run --rm \
  --add-host=host.docker.internal:host-gateway \
  -v "$(pwd)":/workspace \
  ghcr.io/clonio-dev/clonio:latest connection:test production
```

Also verify database bind addresses and grants allow connections from the container network.

## "The server requires TLS"

```text
staging: FAILED — SQLSTATE[HY000] [3159] Connections using insecure transport are prohibited while --require_secure_transport=ON.
The server requires TLS. Run "clonio connection:update staging" and set transport security to "require" or "verify".
```

The server only accepts encrypted connections, but the connection uses `disable` or was created before transport security existed. PostgreSQL reports the same situation as `pg_hba.conf rejects connection … no encryption`. Set the mode to `require` (or `verify` with the server's CA):

```bash
clonio connection:update staging
```

With a MySQL user that requires a client certificate (`REQUIRE X509`), a plaintext connection instead fails with a generic `Access denied` error, indistinguishable from a wrong password, so no TLS hint is given; run `clonio connection:update <name>` and add a client certificate if the account needs one.

## "TLS handshake failed. The server may not support TLS"

The connection asks for TLS (`require` or `verify`) but the server doesn't offer it. The drivers report it as:

- MySQL/MariaDB: `[2006] MySQL server has gone away` or `[2002] Cannot connect to MySQL using SSL`
- PostgreSQL: `server does not support SSL, but SSL was required`

If the database is on a trusted network, set the mode to `disable`. Otherwise, enable TLS on the server.

## A local PostgreSQL in Docker fails right after `connection:add`

The stock `postgres` image has no TLS, and new connections use `require` by default. Add the connection with `--ssl-mode=disable`, or run `clonio connection:update <name>` and choose `Disable (plaintext)`.

## "TLS handshake failed. Likely causes: …"

```text
TLS handshake failed. Likely causes: the CA file did not sign the server certificate, or the host name "10.0.0.5" is not in the certificate. Use mode "require" to skip verification.
```

Mode `verify` couldn't confirm the server's identity. Check:

- the CA file is the one that signed the server certificate (for managed databases, the provider's current bundle);
- the host in the message is in the server certificate. Connecting by IP address, through a DNS alias, or through Docker's `host.docker.internal` usually fails;
- for SQL Server and for PostgreSQL `verify` without a CA file: the CA is installed in the operating system's trust store.

MySQL reports all of these as the same generic `[2002] Cannot connect to MySQL using SSL`, so Clonio lists them together.

## "Certificate file not found"

```text
Certificate file not found: /home/ci/project/certs/ca.pem
```

A path from the connection's `ssl` block doesn't exist on this machine. Relative paths resolve against the current working directory, so run Clonio from the directory that contains `clonio.json`, or store an absolute or `~/` path. Clonio checks this before connecting.

## Target schema changes are surprising

Run a dry run first:

```bash
clonio cloning:run production.cloning.yaml --target staging --dry-run
```

Disable destructive options unless the target is disposable:

```bash
clonio cloning:run production.cloning.yaml --target staging \
  --no-drop-unknown-tables \
  --no-drop-extra-columns
```

## A table is too large for CI

Use row limits in `.cloning.yaml`, or skip the table for that run:

```bash
clonio cloning:run production.cloning.yaml --target ci --skip-tables=audit_logs
```

## Key remapping uses too much memory

Use encrypted file-based mapping storage:

```bash
clonio cloning:run production.cloning.yaml --target staging --file-based
```

## Need a feature

Open a feature request at [clonio-dev/clonio-cli issues](https://github.com/clonio-dev/clonio-cli/issues/new/choose) and choose the **Feature Request** template.

If Clonio CLI is useful to you, sponsorships are welcome through [GitHub Sponsors](https://github.com/sponsors/clonio-dev).
