FROM dunglas/frankenphp:1-php8.4-alpine

# Install the required PostgreSQL drivers using the built-in helper
RUN install-php-extensions pdo_pgsql pgsql
