#!/bin/bash
set -e

# Railway injects PORT; Apache must listen on it (default 80 locally).
PORT="${PORT:-80}"
sed -i "s/Listen 80/Listen ${PORT}/" /etc/apache2/ports.conf
sed -i "s/<VirtualHost \*:80>/<VirtualHost *:${PORT}>/" /etc/apache2/sites-enabled/000-default.conf

# App reads config via Symfony Dotenv from .env at repo root.
# On Railway there is no .env file — generate it from injected env vars.
if [ ! -f /var/www/html/.env ]; then
    printenv | grep -E '^(SYSTEM_TYPE|RESET_MENU_AT_LOGIN|ENABLE_POS_MODULES|DECIMAL_[A-Z_]+|QUERY_LIMITER|ENABLE_BRANCHADD|DB_HOST|DB_PORT|DB_USER|DB_PASS|DB_SCHEMA|DB_CHARSET|VERSION|RELEASE|LAST_MODIF_ATTR)=' \
        > /var/www/html/.env
fi

# Allow .htaccess rewrites (Yii pretty URLs)
if ! grep -q "AllowOverride All" /etc/apache2/sites-enabled/000-default.conf; then
    sed -i "s#</VirtualHost>#<Directory /var/www/html>\nAllowOverride All\nRequire all granted\n</Directory>\n</VirtualHost>#" /etc/apache2/sites-enabled/000-default.conf
fi

exec apache2-foreground
