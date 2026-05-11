#!/usr/bin/env bash
set -euo pipefail

cd /app

if [ ! -f /app/yii2/.env ]; then
    printf 'Production env file /app/yii2/.env is missing. Mount yii2/.env.prod to /app/yii2/.env.\n' >&2
    exit 1
fi

if [ ! -f vendor/autoload.php ]; then
    printf 'Immutable production image is missing /app/vendor/autoload.php. Rebuild the image with composer.lock present.\n' >&2
    exit 1
fi

for path in \
    /app/uploads/reports \
    /app/yii2/frontend/runtime \
    /app/yii2/backend/runtime \
    /app/yii2/console/runtime \
    /app/yii2/frontend/web/assets \
    /app/yii2/backend/web/assets
do
    mkdir -p "$path" 2>/dev/null || true
done

for path in \
    /app/uploads \
    /app/yii2/frontend/runtime \
    /app/yii2/backend/runtime \
    /app/yii2/console/runtime \
    /app/yii2/frontend/web/assets \
    /app/yii2/backend/web/assets
do
    if [ -w "$path" ]; then
        if id www-data >/dev/null 2>&1; then
            chown -R www-data:www-data "$path"
        fi
        chmod -R u+rwX,g+rwX,o-rwx "$path"
    fi
done

exec "$@"
