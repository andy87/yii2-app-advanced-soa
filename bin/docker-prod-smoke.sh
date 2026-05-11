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

DOCKER_BIN="$(resolve_docker)"
CONFIG_FILE="${PROD_COMPOSE_CONFIG_FILE:-var/ci-logs/docker-prod-config.yml}"

mkdir -p "$(dirname "$CONFIG_FILE")"

export SITE_AUDITOR_ENV_FILE="${SITE_AUDITOR_ENV_FILE:-./yii2/.env.prod.example}"

"$DOCKER_BIN" compose \
    --env-file yii2/.env.prod.example \
    -f docker-compose.yml \
    -f docker-compose.prod.yml \
    config > "$CONFIG_FILE"

assert_config_absent() {
    local pattern="$1"
    local description="$2"

    if grep -Eq "$pattern" "$CONFIG_FILE"; then
        printf 'Unexpected production compose config: %s\n' "$description" >&2
        grep -En "$pattern" "$CONFIG_FILE" >&2 || true
        exit 1
    fi
}

assert_config_present() {
    local pattern="$1"
    local description="$2"

    if ! grep -Eq "$pattern" "$CONFIG_FILE"; then
        printf 'Missing production compose config: %s\n' "$description" >&2
        exit 1
    fi
}

assert_file_absent() {
    local pattern="$1"
    local file="$2"
    local description="$3"

    if grep -Eq "$pattern" "$file"; then
        printf 'Unexpected production file content: %s\n' "$description" >&2
        grep -En "$pattern" "$file" >&2 || true
        exit 1
    fi
}

assert_file_present() {
    local pattern="$1"
    local file="$2"
    local description="$3"

    if ! grep -Eq "$pattern" "$file"; then
        printf 'Missing production file content: %s\n' "$description" >&2
        exit 1
    fi
}

assert_config_absent 'target: /app$' 'application root bind mount'
assert_config_absent 'target: /app/vendor$' 'vendor volume mount'
assert_config_absent 'source: vendor($|[^[:alnum:]_-])' 'vendor named volume'
assert_config_absent 'composer-cache' 'composer cache volume'
assert_config_absent 'published: "?20080"?|published: "?21080"?|published: "?25432"?|published: "?26379"?' 'development published ports'

assert_config_present 'target: /app/yii2/frontend/web/robots\.txt$' 'frontend robots.txt mount'
assert_config_present 'target: /app/yii2/backend/web/robots\.txt$' 'backend robots.txt mount'
assert_config_present 'internal: true' 'private internal network'

assert_file_absent 'composer install' docker/php/entrypoint-prod.sh 'runtime composer install in production entrypoint'
assert_file_present 'FallbackResource /index\.php' docker/apache/frontend.conf 'frontend pretty URL fallback'
assert_file_present 'FallbackResource /index\.php' docker/apache/backend.conf 'backend pretty URL fallback'

printf 'production-docker-smoke-ok\n'
