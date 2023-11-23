# Invoicing System

[![Laravel Forge Site Deployment Status](https://img.shields.io/endpoint?url=https%3A%2F%2Fforge.laravel.com%2Fsite-badges%2Fd1eaa2e6-64c3-4037-b35c-4666c4d64655&style=flat-square)](https://forge.laravel.com/servers/725198/sites/2128375)

## Local Development

1. Requires [Docker](https://www.docker.com/get-started/) and [composer](https://getcomposer.org/download/)
2. Download [application dependencies](https://laravel.com/docs/10.x/sail#installing-composer-dependencies-for-existing-projects):
```
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    laravelsail/php82-composer:latest \
    composer install --ignore-platform-reqs
```
3. Create .env from .env.example
4. Run the following commands:
    * `sail up` to start docker container
    * `sail artisan key:generate` to generate the app key
    * `sail npm install` and `sail composer install` to download dependencies
    * `sail npm run build` to compile the css/js assets or `sail npm run dev` to watch for changes
    * `sail artisan migrate --seed` to migrate the database and seed with dummy logins/data
5. You can now access the site on localhost

### Development services

The following services are already included in the sail config so will be automatically started when running `sail up`.

| Service | Description | Url |
| --- | --- | --- |
| phpMyAdmin | Database administration | [localhost:8080](http://localhost:8080/) |
| mailpit | Local smtp server for email testing | [localhost:8025](http://localhost:8025/) |
