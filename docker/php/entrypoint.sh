#!/usr/bin/env bash
set -e

cd /app

if [ ! -f vendor/autoload.php ]; then
    COMPOSER_ALLOW_SUPERUSER=1 composer install --no-interaction --prefer-dist
fi

php /app/yii2/init --env=Development --overwrite=All --interactive=0 >/tmp/site-auditor-init.log

python3 - <<'PY'
from pathlib import Path

path = Path('/app/yii2/.env')
if not path.exists():
    path.write_text(Path('/app/yii2/.env.example').read_text())

data = path.read_text()
replacements = {
    'PROJECT_NAME="SOA APP"': 'PROJECT_NAME="Site Auditor"',
    'PROJECT_ID="soa_app"': 'PROJECT_ID="site_auditor"',
    'DB_DRIVER=mysql': 'DB_DRIVER=pgsql',
    'DB_HOST=127.0.0.1': 'DB_HOST=postgres',
    'DB_NAME=yii2advanced': 'DB_NAME=site_auditor',
    'DB_USERNAME="root"': 'DB_USERNAME="site_auditor"',
    'DB_PASSWORD=""': 'DB_PASSWORD="site_auditor"',
    'DB_CHARSET=utf8mb4': 'DB_CHARSET=utf8',
    'APP_FRONTEND_HOST=http://127.0.0.1:80 # or http://localhost': 'APP_FRONTEND_HOST=http://localhost:20080',
    'APP_BACKEND_HOST=http://127.0.0.1:81  # or http://admin.localhost': 'APP_BACKEND_HOST=http://localhost:21080',
}
for source, target in replacements.items():
    data = data.replace(source, target)

extra = {
    'REDIS_HOST': 'redis',
    'REDIS_PORT': '6379',
    'REDIS_DATABASE': '0',
    'AUDIT_DEFAULT_PAGE_LIMIT': '20',
    'AUDIT_MAX_PAGE_LIMIT': '100',
    'AUDIT_REQUEST_TIMEOUT': '8',
    'AUDIT_MAX_RESPONSE_BYTES': '1048576',
    'AUDIT_USER_AGENT': 'SiteAuditorBot/0.1 (+http://localhost:20080)',
    'LLM_PROVIDER': 'mock',
    'LLM_BASE_URL': '',
    'LLM_API_KEY': '',
    'LLM_MODEL': '',
    'LLM_PROMPT_VERSION': 'audit-v1',
    'LLM_TIMEOUT': '30',
    'LLM_RETRIES': '2',
    'LLM_RETRY_DELAY_MS': '500',
}
for key, value in extra.items():
    if key not in data:
        data += f"\n{key}={value}"

path.write_text(data.replace('\r\n', '\n').replace('\r', '\n'))
PY

mkdir -p /app/uploads/reports /app/yii2/frontend/runtime /app/yii2/backend/runtime /app/yii2/console/runtime
chmod -R 0777 /app/uploads /app/yii2/frontend/runtime /app/yii2/backend/runtime /app/yii2/console/runtime /app/yii2/frontend/web/assets /app/yii2/backend/web/assets || true

exec "$@"
