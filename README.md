<p align="center">
    <a href="https://github.com/yiisoft" target="_blank">
        <img src="https://avatars0.githubusercontent.com/u/993323" height="100px">
    </a>
    <h1 align="center">Yii 2 Advanced Project Template</h1>
    <br>
</p>

Yii 2 Advanced Project Template is a skeleton [Yii 2](https://www.yiiframework.com/) application best for
developing complex Web applications with multiple tiers.

The template includes three tiers: front end, back end, and console, each of which
is a separate Yii application.

The template is designed to work in a team development environment. It supports
deploying the application in different environments.

Documentation is at [docs/guide/README.md](docs/guide/README.md).

[![Latest Stable Version](https://img.shields.io/packagist/v/yiisoft/yii2-app-advanced.svg)](https://packagist.org/packages/yiisoft/yii2-app-advanced)
[![Total Downloads](https://img.shields.io/packagist/dt/yiisoft/yii2-app-advanced.svg)](https://packagist.org/packages/yiisoft/yii2-app-advanced)
[![build](https://github.com/yiisoft/yii2-app-advanced/workflows/build/badge.svg)](https://github.com/yiisoft/yii2-app-advanced/actions?query=workflow%3Abuild)


# Installation

### Clone the repository
```bash
git clone git@github.com:andy87/yii2-app-advanced-soa.git .
```

### Install dependencies
```bash
composer install
```

### Change directory to `app`
```bash
cd app
```

### Initialize application
```bash
php init
```

### Run migrations
```bash
php yii migrate
php yii_test migrate
```

### Run fixtures
```bash
php yii fixture/load "*"
```


### Change directory to project `root`
```bash
cd ../
```

### Build codeception tests
```bash
./vendor/bin/codecept build
```

### Check the application with codeception tests
```bash
./vendor/bin/codecept run
```

___
Я люблю Yii2 за его простоту и функциональность. Поэтому я решил создать свой шаблон приложения, который будет содержать, более расширенную структуру.
В данном шаблоне я добавил следующие папки:

- `app` - содержит только части приложения Yii2.
- `uploads` - содержит загруженные файлы пользователей.
- 
в подпапках `app` добавлены следующие папки:
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


DIRECTORY STRUCTURE
-------------------

```
app/ [+]                contains only parts of the Yii2 application
    common/
        components/ [+]      contains common components
        config/              contains shared configurations
        fixterus/            contains data for fixtures
        mail/                contains view files for e-mails
        models/              contains model classes used in both backend and frontend
            dto/ [+]            contains DTO models
            forms/ [+]          contains web Forms models
            sources/ [+]        contains sources generated models
        repository/          contains common repository classes
        runtime/             contains common generater files
        services/            contains common services classes
        tests/               contains common tests for common classes
        widget/              contains common widgets classes
    console/
        config/              contains console configurations
        controllers/         contains console controllers (commands)
        migrations/          contains database migrations
        models/              contains console-specific model classes
        repository/ [+]      contains repository classes
        runtime/             contains files generated during runtime
        services/ [+]        contains console services classes
    backend/
        assets/              contains application assets such as JavaScript and CSS
        components/ [+]      contains backend components
        config/              contains backend configurations
        controllers/         contains Web controller classes
        models/              contains backend-specific model classes
        repository/ [+]      contains backend repository classes
        resources/ [+]       contains backend resources classes
        runtime/             contains files generated during runtime
        services/ [+]        contains backend services classes
        tests/               contains tests for backend application    
        views/               contains view files for the Web application
        web/                 contains the entry script and Web resources
    frontend/
        assets/              contains application assets such as JavaScript and CSS
        components/ [+]      contains frontend components
        config/              contains frontend configurations
        config/              contains frontend configurations
        controllers/         contains Web controller classes
        models/              contains frontend-specific model classes
        repository/ [+]      contains frontend repository classes
        resources/ [+]       contains frontend resources classes
        runtime/             contains files generated during runtime
        services/ [+]        contains frontend services classes
        tests/               contains tests for frontend application
        views/               contains view files for the Web application
        web/                 contains the entry script and Web resources
        widgets/             contains frontend widgets
    environments/            contains environment-based overrides
vendor/                 contains dependent 3rd-party packages
uploads/                contains uploaded files
```