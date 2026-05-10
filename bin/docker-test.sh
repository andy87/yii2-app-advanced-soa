#!/usr/bin/env bash
set -euo pipefail

ROOT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)"
cd "$ROOT_DIR"

resolve_docker() {
    if command -v docker >/dev/null 2>&1; then
        printf '%s\n' docker
        return
    fi

    if command -v docker.exe >/dev/null 2>&1; then
        printf '%s\n' docker.exe
        return
    fi

    if [ -x "/mnt/c/Program Files/Docker/Docker/resources/bin/docker.exe" ]; then
        printf '%s\n' "/mnt/c/Program Files/Docker/Docker/resources/bin/docker.exe"
        return
    fi

    printf 'Docker CLI not found.\n' >&2
    exit 1
}

read_env_value() {
    local key="$1"
    local file="yii2/.env"

    if [ ! -f "$file" ]; then
        file="yii2/.env.example"
    fi

    if [ ! -f "$file" ]; then
        return
    fi

    awk -F '=' -v key="$key" '$1 == key {print substr($0, length(key) + 2)}' "$file" \
        | tail -n 1 \
        | sed -E 's/[[:space:]]+#.*$//; s/^"//; s/"$//; s/^'\''//; s/'\''$//'
}

DOCKER_BIN="$(resolve_docker)"
TEST_DB_NAME="${TEST_DB_NAME:-$(read_env_value DB_NAME_TEST)}"
POSTGRES_USER="${POSTGRES_USER:-$(read_env_value DB_USERNAME)}"
PHP_ERROR_REPORTING="${PHP_ERROR_REPORTING:-8191}"

TEST_DB_NAME="${TEST_DB_NAME:-yii2advanced_test}"
POSTGRES_USER="${POSTGRES_USER:-site_auditor}"

compose() {
    "$DOCKER_BIN" compose -f docker-compose.yml -f docker-compose.test.yml "$@"
}

cleanup() {
    local status="$?"

    if [ "$status" -eq 0 ] && [ "${KEEP_TEST_CONTAINERS:-0}" != "1" ]; then
        compose down
    fi

    exit "$status"
}

wait_for_postgres() {
    local attempt

    for attempt in $(seq 1 30); do
        if compose exec -T postgres sh -lc "pg_isready -U '$POSTGRES_USER' -d postgres >/dev/null 2>&1 && psql -U '$POSTGRES_USER' -d postgres -c 'select 1' >/dev/null 2>&1"; then
            return
        fi

        sleep 1
    done

    printf 'PostgreSQL is not ready after 30 seconds.\n' >&2
    exit 1
}

reset_test_database() {
    local attempt

    for attempt in $(seq 1 30); do
        if compose exec -T postgres sh -lc "dropdb -U '$POSTGRES_USER' --if-exists --force '$TEST_DB_NAME' && createdb -U '$POSTGRES_USER' '$TEST_DB_NAME'"; then
            return
        fi

        printf 'Test DB reset failed, retry %s/30.\n' "$attempt" >&2
        sleep 1
        wait_for_postgres
    done

    printf 'Unable to reset test database `%s`.\n' "$TEST_DB_NAME" >&2
    exit 1
}

run_unit_suite() {
    local config_path="$1"

    compose run --rm frontend \
        php -d "error_reporting=${PHP_ERROR_REPORTING}" \
        ./vendor/bin/codecept run \
        -c "$config_path" \
        unit \
        --no-colors
}

trap cleanup EXIT

compose up -d postgres redis
wait_for_postgres

reset_test_database

compose run --rm frontend php /app/yii2/yii_test migrate --interactive=0
compose run --rm frontend php -d "error_reporting=${PHP_ERROR_REPORTING}" ./vendor/bin/codecept build

run_unit_suite yii2/common
run_unit_suite yii2/frontend
run_unit_suite yii2/backend
