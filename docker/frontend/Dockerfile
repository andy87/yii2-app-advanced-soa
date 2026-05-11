FROM php:8.4-apache

ENV APACHE_DOCUMENT_ROOT=/app/yii2/frontend/web

RUN apt-get update \
    && apt-get install -y --no-install-recommends \
        git \
        unzip \
        python3 \
        libcurl4-openssl-dev \
        libicu-dev \
        libpq-dev \
        libsqlite3-dev \
        libzip-dev \
        libpng-dev \
        libjpeg-dev \
        libfreetype6-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j"$(nproc)" curl intl pdo pdo_pgsql pdo_sqlite zip gd opcache \
    && a2enmod rewrite \
    && sed -ri "s!/var/www/html!${APACHE_DOCUMENT_ROOT}!g" /etc/apache2/sites-available/000-default.conf /etc/apache2/apache2.conf \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
COPY docker/php/entrypoint.sh /usr/local/bin/site-auditor-entrypoint
COPY docker/php/entrypoint-prod.sh /usr/local/bin/site-auditor-prod-entrypoint
RUN chmod +x /usr/local/bin/site-auditor-entrypoint /usr/local/bin/site-auditor-prod-entrypoint

WORKDIR /app

ENTRYPOINT ["site-auditor-entrypoint"]
CMD ["apache2-foreground"]
