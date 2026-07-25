FROM php:8.3-apache

# System libs for gd, intl, zip, soap
RUN apt-get update && apt-get install -y --no-install-recommends \
        libpng-dev libjpeg62-turbo-dev libfreetype6-dev \
        libicu-dev libzip-dev libxml2-dev unzip git default-mysql-client \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd intl zip soap pdo_mysql mysqli \
    && a2enmod rewrite \
    && rm -rf /var/lib/apt/lists/*

# Force exactly one MPM (prefork — required by mod_php).
# Direct symlink manipulation is more reliable than a2dismod/a2enmod scripts,
# which exit non-zero when a module is already disabled (silent failure in && chains).
RUN find /etc/apache2/mods-enabled -name 'mpm_*.conf' -o -name 'mpm_*.load' | xargs rm -f \
    && ln -sf /etc/apache2/mods-available/mpm_prefork.conf /etc/apache2/mods-enabled/mpm_prefork.conf \
    && ln -sf /etc/apache2/mods-available/mpm_prefork.load /etc/apache2/mods-enabled/mpm_prefork.load \
    && apachectl configtest

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html
COPY . .

RUN composer install --no-dev --optimize-autoloader --no-interaction \
    && mkdir -p backend/runtime console/runtime assets backendassets \
    && chown -R www-data:www-data backend/runtime console/runtime assets backendassets fimages

COPY docker/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

EXPOSE 80
ENTRYPOINT ["entrypoint.sh"]
