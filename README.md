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
git clone git@github.com:andy87/yii2-app-advanced-soa.git .

# Install dependencies
composer install

# Change directory to `app`
cd yii2

# Initialize application
php init

# Select Dev/Prod

# Run migrations
php yii migrate
php yii_test migrate
```
### Codeception tests

console move to `root/app` directory application and run the following commands:

### Build codeception tests
```bash
./vendor/bin/codecept build
```

### Check the application with codeception tests ([Yii2 guide](https://github.com/yiisoft/yii2-app-advanced/blob/master/docs/guide/start-testing.md))
```bash
./vendor/bin/codecept run
```

# Информация

___
Я люблю Yii2 за его простоту и функциональность, поэтому захотелось создать свою сборку шаблона приложения.  
**Особенности этого шаблона**:
 - все файлы declare(strict_types=1)
 - nullable warning style
 - работает на PHP от 8 версии
 - имеет более расширенную структуру директорий и абстракцию
 - предустановленные пакеты(которыми приходится часто пользоваться).


### Были добавлены следующие пакеты
- [vlucas/phpdotenv](https://github.com/vlucas/phpdotenv) - для работы с переменными окружения  
- [mihaildev/yii2-ckeditor](https://github.com/MihailDev/yii2-ckeditor?tab=readme-ov-file) - для работы с редактором текста  
- [kartik-v/yii2-widget-select2](https://demos.krajee.com/widget-details/select2) - для работы с выпадающим списком    
- [kartik-v/yii2-icons](https://demos.krajee.com/icons) - для работы с иконками  
- [andy87/knockknock](https://github.com/andy87/knockknock) - для запросов
- [andy87/yii2-migrate-architect](https://github.com/andy87/yii2-migrate-architect) - для работы с миграциями
- [andy87/yii2-file-crafter](https://github.com/andy87/yii2-file-crafter) - для массовой генерации файлов
- [andy87/lazy-load-trait](https://github.com/andy87/lazy-load-trait) - для отложено загрузки свойств(lazyLoad)
  
### Файлы
 - Вырезаны `bat` файлы.  
 - В `dev` окружение добавлен файл `yii2/reset` для удаления локальных файлов сгенерированных через команду `init`
 - Все тесты адаптированы под работу с `Service` и `Repository`
 - Всем основных классам добавлены родительские `abstract class`
 
### Директории:
- `yii2` - в корне проекта, содержит только части приложения Yii2.
- `uploads` - в корне проекта, содержит загруженные файлы пользователей.

В директории приложения `yii2` добавлены, дочерние папки:
#### Common
- `common/components` - содержит компоненты, которые могут использоваться во всех частях приложения.
- `common/services` - содержит сервисы, которые могут использоваться во всех частях приложения, а так же являются родителями для других сервисов.
- `comman/handles` - содержит обработчики, родительские классы для обработчиков в директориях `console`, `backend` и `frontend`
- `comman/producers` - содержит компонент, реализующий добавление данных в систему.
- `common/repository` - содержит репозитории, которые могут использоваться во всех частях приложения, а так же являются родителями для других репозиториев.
  - `common/models/sources` - содержит модели, которые были сгенерированы с помощью `gii`, а так же унаследованы от них "боевые" модели.
  - `common/models/dto` - содержит модели, которые используются для передачи данных между сервисами.
  - `common/models/forms` - содержит модели форм, которые используются для комбинирования данных, при обработке действия пользователя.

#### Console
- `console/services` - содержит сервисы, которые используются в `console` командах.
- `console/producers` - содержит компонент, реализующий добавление данных в систему.
- `console/repository` - содержит репозитории, которые используются в `console` сервисах.
- `console/handlers` - содержит обработчики, в которых реализуется логика, используя методы `services` и `repository`.

#### Backend
- `backend/components` - содержит компоненты, которые используются в `backend` части приложения.
- `backend/services` - содержит сервисы, которые используются в `backend` части приложения.
- `backend/producers` - содержит компонент, реализующий добавление данных в систему.
- `backend/repository` - содержит репозитории, которые используются в `backend` сервисах.
- `backend/handlers` - содержит обработчики, в которых реализуется логика, используя методы `services` и `repository`.
- `backend/resources` _(ViewModel)_ - содержит ресурсы, которые используются `backend/views`.

#### Frontend
- `frontend/components` - содержит компоненты, которые используются в `frontend` части приложения.
- `frontend/services` - содержит сервисы, которые используются в `frontend` части приложения.
- `frontend/producers` - содержит компонент, реализующий добавление данных в систему.
- `frontend/repository` - содержит репозитории, которые используются в `frontend` сервисах.
- `frontend/handlers` - содержит обработчики, в которых реализуется логика, используя методы `services` и `repository`.
- `frontend/resources` _(ViewModel)_ - содержит ресурсы, которые используются `frontend/views`.


### Init
Немного изменён Init.
1. создаёт файл `.env` из шаблона `.env.example`.
2. проставляет права на папку `uploads`.
3. генерирует файлы `.htaccess` для Apache сервера.


## Gii Generator

### EXAMPLE `frontend`
* Model Class `yii2\common\models\sources\{Item}` 
* Search Model Class `yii2\common\models\search\{Item}Search`
* Controller Class `yii2\(backend|frontend)\controllers\sources\{Item}Controller`
* View Path `@(backend|frontend)/views/sources/{item}`

DIRECTORY STRUCTURE
-------------------

```
uploads/              +   содержит загруженные пользователем файлы
yii2/                  +   содержит только части приложения Yii2
    environments/         содержит переопределения на основе окружения

    common/               окружение - общее
        components/   +       содержит общие компоненты
        config/               содержит общие конфигурации
        fixterus/             содержит данные для фикстур
        handlers/     +       содержит реализацию логики, используя методы `services` и `repository`.
        mail/                 содержит аблоны электронных писем
        models/               содержит классы моделей, используемые всеми окружениями
            dto/      +           содержит модели DTO
            forms/    +           содержит модели веб-форм
            sources/  +           содержит модели, созданные gii и унаследованные от них модели, с кастомной логикой
        producers/    +       содержит общие классы реализующие добавление данных в систему
        repository/   +       содержит общие классы репозиториев
        runtime/              содержит runtime сгенерированные файлы
        services/     +       содержит общие классы сервисов
        tests/                содержит общие тесты для общих классов
        widget/               содержит общие классы виджетов

    console/              окружение - консоль
        config/               содержит конфигурации консоли
        controllers/          содержит консольные контроллеры (команды)
        handlers/    +        содержит реализацию логики, используя методы `services` и `repository`.
        migrations/           содержит миграции базы данных
        models/               содержит модели, специфичные для консоли
        producers/   +        содержит классы реализующие добавление данных в систему
        repository/  +        содержит классы репозиториев
        runtime/              содержит runtime сгенерированные файлы
        services/    +        содержит классы сервисов консоли

    backend/              окружение - бэка(админка)
        assets/               содержит ресурсы приложения, такие как JavaScript и CSS
        components/  +        содержит компоненты для backend
        config/               содержит конфигурации backend
        controllers/          содержит веб-классы контроллеров
        handlers/    +        содержит реализацию логики, используя методы `services` и `repository`.
        models/               содержит модели, специфичные для backend
        producers/   +        содержит классы реализующие добавление данных в систему
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
        handlers/    +        содержит реализацию логики, используя методы `services` и `repository`.
        models/               содержит модели, специфичные для frontend
        producers/   +        содержит классы реализующие добавление данных в систему
        repository/  +        содержит классы репозиториев frontend
        resources/   +        содержит классы ресурсов frontend
        runtime/              содержит runtime сгенерированные файлы
        services/    +        содержит классы сервисов frontend
        tests/                содержит тесты для frontend приложения
        views/                содержит файлы представлений для веб-приложения
        web/                  содержит скрипт входа и веб-ресурсы
        widgets/              содержит виджеты для frontend
    
```

### Терминология именования методов.
Как правило, имя метода должно начинаться с глагола, описывающего действие метода.
- **getter** — Получить приватное свойство конкретного объекта
- **setter** — задать приватное свойство конкретного объекта
- **setup...** — задать публичное свойство объекта
- **get** — получить данные исходя из какой-то логики
- **set** — задать какое-то значение исходя из какой-то логики
- **find...** — найти данные в базе
- **construct/generate** — Получить экземпляр класса
- **create/generate** — создать объект модели в runtime  
- **add** — добавление новой записи в базу 
- **handler...** — обработчик события/формы/модели
- **prepare...** — подготовить данные для дальнейшего использования
- **send...** — отправка данных
- **is...** — проверка на условия
- **remove/delete** — удаление записи из базы
- **filter...** — фильтрация данных
- **sort...** — сортировка данных
  