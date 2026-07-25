#!/bin/bash
# set -e removed intentionally: grep exits 1 when no lines match,
# which killed the script under set -e before Apache could start.

PORT="${PORT:-80}"

echo "[entrypoint] PORT=$PORT"

# Patch Apache to listen on Railway's assigned PORT
sed -i "s/Listen 80/Listen ${PORT}/" /etc/apache2/ports.conf
sed -i "s/<VirtualHost \*:80>/<VirtualHost *:${PORT}>/" /etc/apache2/sites-enabled/000-default.conf

# Generate .env from Railway-injected env vars (only if not already present)
if [ ! -f /var/www/html/.env ]; then
    echo "[entrypoint] Writing .env from environment"
    printenv | grep -E '^(SYSTEM_TYPE|RESET_MENU_AT_LOGIN|ENABLE_POS_MODULES|DECIMAL_[A-Z_]+|QUERY_LIMITER|ENABLE_BRANCHADD|DB_HOST|DB_PORT|DB_USER|DB_PASS|DB_SCHEMA|DB_CHARSET|VERSION|RELEASE|LAST_MODIF_ATTR)=' \
        > /var/www/html/.env || true   # grep exits 1 on no match — that's OK
    echo "[entrypoint] .env contents:"
    cat /var/www/html/.env
else
    echo "[entrypoint] .env already exists, skipping"
fi

# Allow .htaccess rewrites (Yii pretty URLs)
if ! grep -q "AllowOverride All" /etc/apache2/sites-enabled/000-default.conf; then
    sed -i "s#</VirtualHost>#<Directory /var/www/html>\nAllowOverride All\nRequire all granted\n</Directory>\n</VirtualHost>#" \
        /etc/apache2/sites-enabled/000-default.conf
fi

echo "[entrypoint] Starting Apache on port $PORT"
exec apache2-foreground
