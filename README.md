# Yii2 Advanced SOA/DNK Template

Yii2 advanced application template with a service-oriented DNK flow on top of Yii2.

The project keeps the standard advanced application split:

- `frontend` - public web application.
- `backend` - admin web application.
- `console` - console commands and migrations.
- `common` - shared models, services, domains, configuration and infrastructure code.

Runtime services used by the template:

- PHP 8.4 in Docker images, project constraint `php >=8.0`.
- PostgreSQL 16.
- Redis 7.
- RabbitMQ 3 with management UI.
- Yii2, Bootstrap 5, Symfony Mailer, Codeception.
- `andy87/yii2-dnk-base` for DNK base classes.

## Requirements

Local development is expected to run through Docker Compose.

Required tools:

- Docker with Docker Compose plugin.
- Composer, when dependencies are installed from the host.
- PHP with `pdo_pgsql`, when Yii console commands are executed from the host instead of Docker.

Host PHP without `pdo_pgsql` cannot run migrations. In that case run Yii commands inside the PHP container.

## Installation

Clone the repository and install dependencies:

```bash
git clone git@github.com:andy87/yii2-app-advanced-soa.git .
composer install
```

Initialize the Yii environment from the `yii2` directory:

```bash
cd yii2
php init --env=Development
cd ..
```

`init` performs the local bootstrap:

- copies environment files from `yii2/environments/dev`;
- creates `yii2/.env` from `yii2/.env.example`, when `.env` does not exist;
- makes runtime, Docker runtime and uploads directories writable;
- creates asset symlinks;
- sets executable flags for `yii`, `yii_test` and `reset`;
- can generate Apache `.htaccess` files in interactive mode.

## Environment

Application settings are stored in `yii2/.env`.

Important variables:

```dotenv
DB_DRIVER=pgsql
DB_HOST=postgresql
DB_PORT=5432
DB_NAME=yii2advanced
DB_USERNAME=yii2advanced
DB_PASSWORD=secret
DB_DSN_LOCAL=${DB_DRIVER}:host=${DB_HOST};port=${DB_PORT};dbname=${DB_NAME}

DB_HOST_TEST=${DB_HOST}
DB_NAME_TEST=yii2advanced_test
DB_DSN_TESTS=${DB_DRIVER}:host=${DB_HOST_TEST};port=${DB_PORT};dbname=${DB_NAME_TEST}

REDIS_CONTAINER_NAME=redis
REDIS_CONTAINER_PORT=6379

RABBITMQ_HOST=rabbitmq
RABBITMQ_PORT=5672
RABBITMQ_USER=guest
RABBITMQ_PASSWORD=guest
```

For Docker Compose keep service host names as `postgresql`, `redis` and `rabbitmq`.

For host-side CLI commands use host ports and host names available from the host machine. PostgreSQL is published as `127.0.0.1:25432`, Redis as `127.0.0.1:26379`, RabbitMQ AMQP as `127.0.0.1:25672`.

## Docker Compose

Start the development stack:

```bash
docker compose up -d --build
```

Services and exposed ports:

- Frontend: `http://127.0.0.1:20080`
- Backend: `http://127.0.0.1:21080`
- PostgreSQL: `127.0.0.1:25432`
- Redis: `127.0.0.1:26379`
- RabbitMQ AMQP: `127.0.0.1:25672`
- RabbitMQ management UI: `http://127.0.0.1:25673`

Run Yii console commands inside a container:

```bash
docker compose exec frontend php yii2/yii migrate
docker compose exec frontend php yii2/yii_test migrate
```

The source tree is mounted to `/app`, so the Yii entrypoints inside containers are `/app/yii2/yii` and `/app/yii2/yii_test`.

## Database Migrations

Migrations are stored in:

```text
yii2/console/migrations
```

Run application migrations:

```bash
php yii2/yii migrate
```

Run test migrations:

```bash
php yii2/yii_test migrate
```

When running from the host, verify that host PHP has `pdo_pgsql` enabled and that `yii2/.env` points to host-reachable services.

## Tests

Codeception is configured by the root `codeception.yml` and includes:

- `yii2/common`
- `yii2/frontend`
- `yii2/backend`

Build generated tester classes:

```bash
./vendor/bin/codecept build
```

Run all tests:

```bash
./vendor/bin/codecept run
```

Run a specific application suite:

```bash
./vendor/bin/codecept run yii2/common/tests
./vendor/bin/codecept run yii2/frontend/tests
./vendor/bin/codecept run yii2/backend/tests
```

Functional and unit suites use Yii2 module configuration from each application `codeception.yml`.

## DNK Flow

The project uses `andy87/yii2-dnk-base` as the base layer for service-oriented domain code.

Main flow:

```text
Controller -> Handler -> Service -> Repository | Producer | Killer
```

Core roles:

- `Domain` - registry of domain classes, payloads and view models.
- `Payload` - input DTO for one action.
- `Handler` - use-case orchestration.
- `Service` - business logic.
- `Repository` - read/query layer.
- `Producer` - model creation layer.
- `Killer` - delete/soft-delete layer.
- `ViewModel` / `Resource` - output data for views/API.
- `QueryStorage` - SQL/query storage for complex reads.

Existing domain examples:

- `yii2/common/domains/identity`
- `yii2/common/domains/user`
- `yii2/frontend/domains/auth`

Use the package base classes instead of duplicating them in the application:

- `andy87\yii2dnk\domain\BaseDomain`
- `andy87\yii2dnk\domain\BaseHandler`
- `andy87\yii2dnk\domain\BaseService`
- `andy87\yii2dnk\domain\BaseRepository`
- `andy87\yii2dnk\domain\BaseProducer`
- `andy87\yii2dnk\domain\BaseKiller`
- `andy87\yii2dnk\BasePayload`
- `andy87\yii2dnk\viewModels\BaseViewModel`
- `andy87\yii2dnk\viewModels\BaseTemplateResource`

## Directory Structure

```text
uploads/                         user uploaded files
runtime/                         shared runtime data
runtime/Docker/postgresql         PostgreSQL data
runtime/Docker/redis              Redis data
runtime/Docker/rabbitMq           RabbitMQ data

yii2/
    environments/                 environment-specific files for init

    common/
        components/               shared components, traits, interfaces, forms and base view models
        config/                   shared configuration and DI container definitions
        domains/                  DNK domains shared between apps
        fixtures/                 fixtures
        handlers/                 shared legacy/application handlers
        mail/                     mail views
        models/                   shared models
            dto/                  DTO models
            forms/                form models
            search/               search models
            sources/              source ActiveRecord models generated by Gii
        producers/                shared producers
        queryStorages/            shared query storages
        services/                 shared services
        tests/                    common tests
        views/                    shared views
        widgets/                  shared widgets

    console/
        config/                   console configuration
        controllers/              console controllers
        handlers/                 console handlers
        migrations/               database migrations
        models/                   console models
        producers/                console producers
        queryStorages/            console query storages
        runtime/                  console runtime path
        services/                 console services

    backend/
        assets/                   backend assets
        components/               backend components and base controllers
        config/                   backend configuration
        controllers/              backend web controllers
        handlers/                 backend handlers
        models/                   backend models
        producers/                backend producers
        queryStorages/            backend query storages
        runtime/                  backend runtime path
        services/                 backend services
        tests/                    backend tests
        viewModels/               backend view models
        views/                    backend views
        web/                      backend document root

    frontend/
        assets/                   frontend assets
        components/               frontend components, controllers and actions
        config/                   frontend configuration
        controllers/              frontend web controllers
        domains/                  frontend-specific DNK domains
        handlers/                 frontend handlers
        models/                   frontend models
        producers/                frontend producers
        queryStorages/            frontend query storages
        runtime/                  frontend runtime path
        services/                 frontend services
        tests/                    frontend tests
        viewModels/               frontend view models
        views/                    frontend views
        web/                      frontend document root
```

## Gii Model Generation

Generate source models into `yii2\common\models\sources`.

Example:

```bash
php yii2/yii gii/model \
  --tableName=table_name \
  --modelClass=TableName \
  --baseClass="andy87\\yii2dnk\\BaseModel" \
  --ns="yii2\\common\\models\\sources" \
  --generateLabelsFromComments=1
```

Source models are intended to be regenerated. Domain-specific logic should live in the application model, domain service, repository, producer, handler or view model.

## Main Dependencies

Runtime dependencies:

- `yiisoft/yii2`
- `yiisoft/yii2-bootstrap5`
- `yiisoft/yii2-symfonymailer`
- `yiisoft/yii2-redis`
- `mikemadisonweb/yii2-rabbitmq`
- `vlucas/phpdotenv`
- `mihaildev/yii2-ckeditor`
- `kartik-v/yii2-widget-select2`
- `kartik-v/yii2-icons`
- `andy87/knockknock`
- `andy87/yii2-migrate-architect`
- `andy87/lazy-load-trait`
- `andy87/yii2-dnk-base`

Development dependencies:

- `yiisoft/yii2-debug`
- `yiisoft/yii2-gii`
- `yiisoft/yii2-faker`
- `phpunit/phpunit`
- `codeception/codeception`
- `andy87/yii2-file-crafter`

## Method Naming

General convention: method names start with a verb that describes the action.

- `getter` - return a private property of the current object.
- `setter` - set a private property of the current object.
- `setup...` - set a public object property.
- `get...` - get data using application logic.
- `set...` - set data using application logic.
- `find...` - find data in storage.
- `construct...` / `generate...` - build an object instance.
- `create...` / `generate...` - create a runtime model/object.
- `add...` - add a database record.
- `handle...` - handle an event, form or model.
- `prepare...` - prepare data for later use.
- `send...` - send data.
- `is...` - check a condition.
- `remove...` / `delete...` - remove a database record.
- `filter...` - filter data.
- `sort...` - sort data.
