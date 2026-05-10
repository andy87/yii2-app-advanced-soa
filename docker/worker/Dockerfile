FROM php:8.4-cli

RUN apt-get update \
    && apt-get install -y --no-install-recommends \
        git \
        unzip \
        python3 \
        libicu-dev \
        libpq-dev \
        libsqlite3-dev \
        libzip-dev \
        libpng-dev \
        libjpeg-dev \
        libfreetype6-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j"$(nproc)" intl pdo pdo_pgsql pdo_sqlite zip gd opcache \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
COPY docker/php/entrypoint.sh /usr/local/bin/site-auditor-entrypoint
RUN chmod +x /usr/local/bin/site-auditor-entrypoint

WORKDIR /app

ENTRYPOINT ["site-auditor-entrypoint"]
CMD ["php", "/app/yii2/yii", "queue/listen", "--verbose=1"]
