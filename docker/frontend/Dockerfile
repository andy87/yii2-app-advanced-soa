FROM php:8.4-apache

WORKDIR /app

RUN apt-get update \
    && apt-get install -y --no-install-recommends \
        libfreetype6-dev \
        libicu-dev \
        libjpeg62-turbo-dev \
        libpng-dev \
        libpq-dev \
        libzip-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd intl pdo_pgsql zip \
    && a2enmod rewrite \
    && rm -rf /var/lib/apt/lists/*

RUN { \
        echo '<VirtualHost *:80>'; \
        echo '    DocumentRoot /app/yii2/frontend/web'; \
        echo '    <Directory /app/yii2/frontend/web>'; \
        echo '        Options FollowSymLinks'; \
        echo '        AllowOverride All'; \
        echo '        Require all granted'; \
        echo '        RewriteEngine On'; \
        echo '        RewriteCond %{REQUEST_FILENAME} !-f'; \
        echo '        RewriteCond %{REQUEST_FILENAME} !-d'; \
        echo '        RewriteRule ^ index.php [L]'; \
        echo '    </Directory>'; \
        echo '</VirtualHost>'; \
    } > /etc/apache2/sites-available/000-default.conf
