<span style="text-align: center">
    <a href="https://github.com/yiisoft" target="_blank">
        <img src="https://avatars0.githubusercontent.com/u/993323" height="100px" alt="logo" />
    </a>
    <h1 style="text-align: center">Yii 2 Advanced Project Template</h1>
    <br>
</span>

Yii 2 Advanced Project Template is a skeleton [Yii 2](https://www.yiiframework.com/) application best for
developing complex Web applications with multiple tiers.

The template includes three tiers: front end, back end, and console, each of which
is a separate Yii application.

The template is designed to work in a team development environment. It supports
deploying the application in different environments.

Documentation is at [docs/guide/README.md](https://github.com/yiisoft/yii2-app-advanced/blob/master/docs/guide/README.md).

[![Latest Stable Version](https://img.shields.io/packagist/v/yiisoft/yii2-app-advanced.svg)](https://packagist.org/packages/yiisoft/yii2-app-advanced)
[![Total Downloads](https://img.shields.io/packagist/dt/yiisoft/yii2-app-advanced.svg)](https://packagist.org/packages/yiisoft/yii2-app-advanced)
[![build](https://github.com/yiisoft/yii2-app-advanced/workflows/build/badge.svg)](https://github.com/yiisoft/yii2-app-advanced/actions?query=workflow%3Abuild)


# Installation ([Yii2 guide](https://github.com/yiisoft/yii2-app-advanced/blob/master/docs/guide/start-installation.md#installation))

console move to `root` directory application and run the following commands:
```bash
composer create-project --prefer-dist yiisoft/yii2-app-advanced-soa .

# Install dependencies
composer install

# Change directory to `app`
cd app

# Initialize application
php init --env=Development --overwrite=All --delete=All

# Run migrations
php yii migrate
php yii_test migrate

# Run fixtures
php yii fixture/load "*"

```
### Codeception tests

console move to `root/app` directory application and run the following commands:

### Build codeception tests
```bash
./vendor/bin/codecept build
```

### Check the application with codeception tests ([Yii2 guide](https://github.com/yiisoft/yii2-app-advanced/blob/master/docs/guide/start-testing.md))
```bash
./vendor/bin/codecept run app/common/tests

./vendor/bin/codecept run app/backend/tests

./vendor/bin/codecept run app/frontend/tests/unit

```
___
Я люблю Yii2 за его простоту и функциональность. 
Поэтому захотелось создать свой шаблон приложения, который будет содержать, более расширенную структуру и
некоторые предустановленные пакеты, которыми приходится часто пользоваться.

Были добавлены следующие пакеты:
- `vlucas/phpdotenv` - для работы с переменными окружения.
- `mihaildev/yii2-ckeditor` - для работы с редактором текста.
- `kartik-v/yii2-widget-select2` - для работы с select.  

#### Файлы
 - Вырезаны `bat` файлы.  
 - Для `dev` кружения добавлен файл `app/reset` для удаления локальных файлов сгенерированных через команду `init`
 
Были добавлены следующие папки:
- `app` - содержит только части приложения Yii2.
- `uploads` - содержит загруженные файлы пользователей.

В дочерних папках директории `app` добавлены следующие папки:
#### Common
- `common/components` - содержит компоненты, которые могут использоваться во всех частях приложения.
- `common/services` - содержит сервисы, которые могут использоваться во всех частях приложения, а так же являются родителями для других сервисов.
- `common/repository` - содержит репозитории, которые могут использоваться во всех частях приложения, а так же являются родителями для других репозиториев.
  - `common/models/sources` - содержит модели, которые были сгенерированы с помощью `gii`, а так же унаследованы от них "боевые" модели.
  - `common/models/dto` - содержит модели, которые используются для передачи данных между сервисами.
  - `common/models/forms` - содержит модели форм, которые используются для комбинирования данных, при обработке действия пользователя.

#### Console
- `console/services` - содержит сервисы, которые используются в `console` командах.
- `console/repository` - содержит репозитории, которые используются в `console` сервисах.

#### Backend
- `backend/components` - содержит компоненты, которые используются в `backend` части приложения.
- `backend/services` - содержит сервисы, которые используются в `backend` части приложения.
- `backend/repository` - содержит репозитории, которые используются в `backend` сервисах.
- `backend/resources`(_ViewModel_) - содержит ресурсы, которые используются в `backend` части приложения.


#### Frontend
- `frontend/components` - содержит компоненты, которые используются в `frontend` части приложения.
- `frontend/services` - содержит сервисы, которые используются в `frontend` части приложения.
- `frontend/repository` - содержит репозитории, которые используются в `frontend` сервисах.
- `frontend/resources`(_ViewModel_) - содержит ресурсы, которые используются в `frontend` части приложения.


### Init
Немного изменён Init.
1. Теперь он создаёт файл `.env` из шаблона `.env.example` и добавляет в него случайный ключ `SECRET_KEY`.
2. Так же он проставляет права на папку `uploads`.

DIRECTORY STRUCTURE
-------------------

```
uploads/              +   содержит загруженные пользователем файлы
app/                  +   содержит только части приложения Yii2
    environments/         содержит переопределения на основе окружения

    common/               окружение - общее
        components/   +       содержит общие компоненты
        config/               содержит общие конфигурации
        fixterus/             содержит данные для фикстур
        mail/                 содержит аблоны электронных писем
        models/               содержит классы моделей, используемые всеми окружениями
            dto/      +           содержит модели DTO
            forms/    +           содержит модели веб-форм
            sources/  +           содержит модели, созданные gii и унаследованные от них модели, с кастомной логикой
        repository/   +       содержит общие классы репозиториев
        runtime/              содержит runtime сгенерированные файлы
        services/     +       содержит общие классы сервисов
        tests/                содержит общие тесты для общих классов
        widget/               содержит общие классы виджетов

    console/              окружение - консоль
        config/               содержит конфигурации консоли
        controllers/          содержит консольные контроллеры (команды)
        migrations/           содержит миграции базы данных
        models/               содержит модели, специфичные для консоли
        repository/  +        содержит классы репозиториев
        runtime/              содержит runtime сгенерированные файлы
        services/    +        содержит классы сервисов консоли

    backend/              окружение - бэка(админка)
        assets/               содержит ресурсы приложения, такие как JavaScript и CSS
        components/  +        содержит компоненты для backend
        config/               содержит конфигурации backend
        controllers/          содержит веб-классы контроллеров
        models/               содержит модели, специфичные для backend
        repository/  +        содержит классы репозиториев backend
        resources/   +        содержит классы ресурсов backend
        runtime/              содержит runtime сгенерированные файлы
        services/    +        содержит классы сервисов backend
        tests/                содержит тесты для backend приложения    
        views/                содержит файлы представлений для веб-приложения
        web/                  содержит скрипт входа и веб-ресурсы

    frontend/             окружение - фронт(пользовательская часть)
        assets/               содержит ресурсы приложения, такие как JavaScript и CSS
        components/  +        содержит компоненты для frontend
        config/               содержит конфигурации frontend
        controllers/          содержит веб-классы контроллеров
        models/               содержит модели, специфичные для frontend
        repository/  +        содержит классы репозиториев frontend
        resources/   +        содержит классы ресурсов frontend
        runtime/              содержит runtime сгенерированные файлы
        services/    +        содержит классы сервисов frontend
        tests/                содержит тесты для frontend приложения
        views/                содержит файлы представлений для веб-приложения
        web/                  содержит скрипт входа и веб-ресурсы
        widgets/              содержит виджеты для frontend
    
```