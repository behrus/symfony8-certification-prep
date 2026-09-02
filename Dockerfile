FROM dunglas/frankenphp:1-php8.3-bookworm

RUN install-php-extensions pdo_pgsql intl zip apcu opcache