# Local environment (no Docker)

The Docker assets were removed, but you can run a full local stack with the same pieces (PHP + MariaDB) using the host tools below.

## Prerequisites
- PHP 8.5+ with `pdo_mysql`, `curl`, `json`, `mbstring`, `openssl`, `xml` extensions
- MariaDB/MySQL running locally
- Composer (or allow the bootstrap script to download `composer.phar`)
- Node is **not** required

## 1) Bootstrap dependencies
From the repository root:

```bash
./dev/bootstrap-local.sh
```

This installs Composer dependencies and creates `config.php` from the sample if it is missing. Edit `config.php` to align database credentials and base URL with your machine.

## 2) Prepare the database
Create the database and user the same way the Docker Compose file did:

```bash
sudo ./setup-mysql.sh
```

This helper creates a `psm` database and a `psm` user with the password `psm-dev-password`. Update `config.php` if you pick different credentials or prefer to create the database manually.

## 3) Start the app
Run the built-in PHP server:

```bash
./dev/start-local.sh
```

This serves the app at `http://localhost:8080` using `public.php` as the router (equivalent to the nginx+PHP-FPM setup in the old Docker image). Use `ctrl+c` to stop the server.

## 4) Optional: system services
For a closer match to the Docker setup, you can configure nginx and php-fpm using the sample config in `dev/phpservermon-default`. Point nginx at the repository root and keep `public.php` as the front controller.

## 5) Troubleshooting
- **Composer not found:** the bootstrap script downloads `composer.phar` automatically.
- **Database connection issues:** ensure `pdo_mysql` is enabled and credentials in `config.php` match your local MariaDB settings.
- **Port conflicts:** edit `PORT` in `dev/start-local.sh` if `8080` is already in use.
