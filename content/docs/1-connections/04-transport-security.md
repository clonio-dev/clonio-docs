---
title: Transport Security (TLS)
excerpt: Encrypt database connections, verify server certificates, and use client certificates for mutual TLS.
---

# Transport Security (TLS)

Every network connection (`mysql`, `mariadb`, `pgsql`, `sqlsrv`) has a transport security mode. It decides whether the connection is encrypted and whether Clonio checks that it is talking to the right server.

## Modes

| Mode | Encrypted | Server certificate checked | Use it when |
|---|---|---|---|
| `disable` | No | — | Local development or a trusted private network, and the server has no TLS (for example the stock `postgres` Docker image) |
| `require` | Yes | No | The server enforces TLS or uses a self-signed certificate. Protects against eavesdropping, not against a server pretending to be yours |
| `verify` | Yes | Yes: the CA **and** the host name | Production databases, especially across networks you don't control |
| default | Driver default | Driver default | Connections created before transport security existed (no `ssl` in `clonio.json`) |

There is no `prefer` mode. Clonio never silently falls back from TLS to plaintext.

## Default for new connections

`clonio connection:add` preselects `require`, and `--no-interaction` stores `require` unless you pass `--ssl-mode`. Servers that enforce TLS, such as MySQL with `require_secure_transport=ON` or managed cloud databases, work without further setup.

SQL Server (`sqlsrv`) is the exception: it defaults to `verify` instead, because ODBC Driver 18 already verifies the server certificate by default — `require` would weaken it.

Existing connections in `clonio.json` are not changed. They keep the driver default until you run `clonio connection:update` and pick a mode.

A server without TLS rejects `require`. Use `disable` for it:

```bash
clonio connection:add local-pg --type=pgsql --host=127.0.0.1 --port=5432 \
  --database=app --schema=public --username=postgres --password=secret \
  --ssl-mode=disable
```

## Adding a connection with TLS

Interactively, `connection:add` asks for transport security right after the password:

- `Require (encrypted, not verified)` (default, except SQL Server which defaults to `Verify`)
- `Verify (encrypted + certificate check)`: then asks for the CA certificate path (not for SQL Server)
- `Disable (plaintext)`
- `Driver default`

For `Require` and `Verify` it then offers to add a client certificate and key (not for SQL Server).

Non-interactive options:

| Option | Meaning |
|---|---|
| `--ssl-mode=` | `disable`, `require` or `verify` |
| `--ssl-ca=` | CA certificate (PEM). Only with `verify`; required for MySQL and MariaDB |
| `--ssl-cert=` | Client certificate (PEM) for mutual TLS. Needs `--ssl-key` |
| `--ssl-key=` | Client private key (PEM) for mutual TLS. Needs `--ssl-cert` |

```bash
clonio connection:add production --type=mysql --host=db.example.com --port=3306 \
  --database=app --username=clonio --password="$DB_PASSWORD" \
  --ssl-mode=verify --ssl-ca=certs/production-ca.pem --production --no-interaction
```

`clonio connection:update` asks the same questions, preselected with the stored values. Certificate path prompts show the stored path: press Enter to keep it, type `none` to remove it, or enter a new path. The change summary lists every transport security change before you save.

## Certificate files

Clonio stores the **paths** you enter, never the file contents, so `clonio.json` contains no key material.

Paths resolve when Clonio connects:

| Path as entered | Resolves to |
|---|---|
| `~/certs/ca.pem` | Your home directory |
| `/etc/ssl/db/ca.pem` | Used as-is |
| `certs/ca.pem` | The current working directory, next to `clonio.json` |

Relative paths keep `clonio.json` portable. The same file works on your machine, in CI and in the Docker image, where the working directory is the mounted project.

Clonio checks the files when you add or update a connection, and again before it connects, before any network traffic. Add or update reports `Certificate file not found or not readable: <path>`; connecting reports `Certificate file not found: <absolute path>`.

Keep private keys out of Git: store them outside the project or list them in `.gitignore`, and restrict them with `chmod 600`. Clonio warns when a key file is readable by other users.

## Mutual TLS

Some servers require the client to present a certificate, such as a MySQL user with `REQUIRE X509` or a PostgreSQL `hostssl … clientcert=verify-ca` rule. Add `--ssl-cert` and `--ssl-key` to `require` or `verify`:

```bash
clonio connection:add production --type=pgsql --host=db.example.com --port=5432 \
  --database=app --schema=public --username=clonio --password="$DB_PASSWORD" \
  --ssl-mode=verify --ssl-ca=certs/ca.pem \
  --ssl-cert=certs/clonio.pem --ssl-key=certs/clonio-key.pem --no-interaction
```

SQL Server connections don't support client certificates.

## Per-driver behaviour

| Driver | `disable` | `require` | `verify` | `verify` without a CA file | default |
|---|---|---|---|---|---|
| `mysql`, `mariadb` | No TLS | TLS, certificate not checked | TLS, CA and host name checked | Not allowed | No TLS |
| `pgsql` | `sslmode=disable` | `sslmode=require` | `sslmode=verify-full` | System trust store | `sslmode=prefer`: TLS if the server offers it |
| `sqlsrv` | `Encrypt=no` | `Encrypt=yes`, `TrustServerCertificate=yes` | `Encrypt=yes`, `TrustServerCertificate=no` | System trust store (always) | ODBC Driver 18: `Encrypt=yes`, certificate checked |

### PostgreSQL

- `verify` without a CA file (`sslrootcert=system`) uses the operating system's trust store. This needs libpq 16 or later; older libpq versions don't recognize `system` and fail to connect. Pass `--ssl-ca` with an explicit CA file to support older libpq.
- Even under `require`, if `~/.postgresql/root.crt` exists on the machine running Clonio, libpq upgrades the connection to verify the server certificate against it. This is libpq's own behavior, independent of Clonio's `ssl.mode`.

### SQL Server

- The ODBC driver takes no certificate paths. `verify` checks the server certificate against the operating system's trust store, so install your CA there.
- ODBC Driver 18 encrypts and verifies by default. A server with a self-signed certificate (the default for SQL Server on Linux and in Docker) fails with the driver default and with `verify`. Use `require`.
- A server configured with `forceencryption=1` encrypts the connection even with `disable`.
- Older `clonio.json` files may contain `"trust_server_certificate": true`. It keeps working. `clonio connection:update` replaces it with `"ssl": { "mode": "require" }`. `--trust-server-certificate` is a deprecated alias for `--ssl-mode=require`, available on `connection:add` only; `connection:update` has no flags and asks the same questions interactively (or keeps stored values with `--no-interaction`).

## Checking a connection

```bash
clonio connection:test production -v
```

```text
production: OK (38ms, tls: verify)
  TLS cipher: TLS_AES_256_GCM_SHA384
```

`connection:list` shows each connection's mode in the `TLS` column. With `-v`, network connections also report the negotiated cipher; if the `TLS cipher` line is missing, the connection is not encrypted. SQL Server does not expose the cipher, so an encrypted SQL Server connection shows `TLS cipher: encrypted (cipher not reported by SQL Server)`. `connection:test` without a name shows the mode for every connection in a `TLS` column, and with `-v` the cipher in a `Cipher` column. When a connection fails, the error comes with a hint; see [Troubleshooting](../5-reference/04-troubleshooting.md).

## `clonio.json`

```json
"production": {
  "type": "mysql",
  "host": "db.example.com",
  "port": 3306,
  "database": "app",
  "username": "clonio",
  "password": "encrypted:…",
  "is_production": true,
  "ssl": {
    "mode": "verify",
    "ca": "certs/production-ca.pem"
  }
}
```

| Key | Allowed with | Notes |
|---|---|---|
| `ssl.mode` | — | Required when `ssl` is present |
| `ssl.ca` | `verify` | Not for `sqlsrv` |
| `ssl.cert`, `ssl.key` | `require`, `verify` | Together or not at all. Not for `sqlsrv` |

Without an `ssl` key, the connection uses the driver default. `ssl` is not allowed on `sqlite` and `dump` connections.

## Managed databases

Managed database services publish the CA that signs their server certificates. Download it into the project, for example as `certs/<provider>-ca.pem`, and use `verify`:

| Provider | CA file |
|---|---|
| AWS RDS / Aurora | `global-bundle.pem` from the RDS "Using SSL/TLS" documentation |
| Google Cloud SQL | `server-ca.pem` from the instance's *Connections → Security* page |
| Azure Database for MySQL / PostgreSQL | The root CAs listed in Azure's TLS documentation for your server type |
| DigitalOcean Managed Databases | `ca-certificate.crt` from the cluster's *Connection details* |

Use the exact host name the provider gives you. `verify` checks it against the certificate, so an IP address or a custom DNS alias fails even with the right CA.

If you don't have the CA at hand, `require` still encrypts the connection. It doesn't prove the server's identity.
