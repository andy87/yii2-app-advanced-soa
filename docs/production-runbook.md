# Production Runbook

Минимальный runbook для production запуска immutable Docker image.

## Переменные

Команды ниже предполагают запуск из корня репозитория.

```bash
export SITE_AUDITOR_ENV_FILE=./yii2/.env.prod
export COMPOSE_PROJECT_NAME=site-auditor
export COMPOSE="docker compose --env-file yii2/.env.prod -f docker-compose.yml -f docker-compose.prod.yml"
```

Перед первым запуском создать env:

```bash
cp yii2/.env.prod.example yii2/.env.prod
```

В `yii2/.env.prod` обязательно заменить `change-me` значения: `DB_PASSWORD`, cookie validation keys, hosts, mailer и `LLM_*`.

После заполнения env загрузить переменные в shell:

```bash
set -a
. "$SITE_AUDITOR_ENV_FILE"
set +a
```

## First Deploy

1. Проверить production compose invariants:

```bash
bin/docker-prod-smoke.sh
```

2. Собрать immutable images:

```bash
$COMPOSE build frontend backend worker
```

3. Запустить сервисы:

```bash
$COMPOSE up -d
```

4. Выполнить миграции:

```bash
$COMPOSE exec worker php /app/yii2/yii migrate --interactive=0
```

5. Проверить состояние:

```bash
$COMPOSE ps
$COMPOSE exec worker php /app/yii2/yii migrate/history
curl -fsS "${APP_FRONTEND_HOST:-http://localhost}/robots.txt"
```

## Update Deploy

1. Получить новую версию кода:

```bash
git fetch origin
git checkout master
git pull --ff-only origin master
```

2. Проверить production compose invariants:

```bash
bin/docker-prod-smoke.sh
```

3. Пересобрать images и обновить контейнеры:

```bash
$COMPOSE build frontend backend worker
$COMPOSE up -d
```

4. Применить миграции:

```bash
$COMPOSE exec worker php /app/yii2/yii migrate --interactive=0
```

5. Проверить health после релиза:

```bash
$COMPOSE ps
$COMPOSE logs --tail=100 frontend backend worker
curl -fsS "${APP_FRONTEND_HOST:-http://localhost}/robots.txt"
curl -fsS "${APP_BACKEND_HOST:-http://localhost}/robots.txt"
```

## Rollback

Rollback безопасен только к версии, совместимой с уже применёнными миграциями. Если новый релиз применил необратимые миграции, сначала восстановить БД из backup.

1. Переключиться на предыдущий commit или tag:

```bash
git checkout <previous-commit-or-tag>
```

2. Пересобрать и поднять предыдущую версию:

```bash
bin/docker-prod-smoke.sh
$COMPOSE build frontend backend worker
$COMPOSE up -d
```

3. Проверить сервисы:

```bash
$COMPOSE ps
$COMPOSE logs --tail=100 frontend backend worker
```

## PostgreSQL Volume Backup

Физический backup volume делать только при остановленном PostgreSQL. Для online backup использовать `pg_dump`/managed DB backup.

1. Создать каталог backup:

```bash
mkdir -p backups
```

2. Остановить сервисы:

```bash
$COMPOSE down
```

3. Снять архив volume:

```bash
docker run --rm \
  -v "${COMPOSE_PROJECT_NAME}_postgres-data:/volume:ro" \
  -v "$PWD/backups:/backup" \
  alpine \
  tar czf "/backup/postgres-data-$(date +%Y%m%d-%H%M%S).tgz" -C /volume .
```

4. Вернуть сервисы:

```bash
$COMPOSE up -d
```

## PostgreSQL Volume Restore

Restore полностью заменяет текущий PostgreSQL volume. Перед restore сохранить текущий volume отдельным backup, если данные могут понадобиться.

1. Остановить сервисы:

```bash
$COMPOSE down
```

2. Пересоздать volume:

```bash
docker volume rm "${COMPOSE_PROJECT_NAME}_postgres-data"
docker volume create "${COMPOSE_PROJECT_NAME}_postgres-data"
```

3. Распаковать backup:

```bash
docker run --rm \
  -v "${COMPOSE_PROJECT_NAME}_postgres-data:/volume" \
  -v "$PWD/backups:/backup:ro" \
  alpine \
  tar xzf "/backup/<backup-file>.tgz" -C /volume
```

4. Запустить сервисы и проверить PostgreSQL:

```bash
$COMPOSE up -d
$COMPOSE exec postgres pg_isready -U "$DB_USERNAME" -d "$DB_NAME"
$COMPOSE exec worker php /app/yii2/yii migrate/history
```

## Health Checks

После deploy или rollback проверить:

```bash
$COMPOSE ps
$COMPOSE exec postgres pg_isready -U "$DB_USERNAME" -d "$DB_NAME"
$COMPOSE exec redis redis-cli ping
$COMPOSE exec worker php /app/yii2/yii migrate/history
curl -fsS "${APP_FRONTEND_HOST:-http://localhost}/robots.txt"
curl -fsS "${APP_BACKEND_HOST:-http://localhost}/robots.txt"
```

Проверить очередь:

```bash
$COMPOSE logs --tail=100 worker
```

Проверить, что DB/Redis не опубликованы наружу:

```bash
$COMPOSE config | grep -E 'published: "?25432"?|published: "?26379"?' && exit 1 || true
```
