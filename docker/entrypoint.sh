#!/bin/bash
# set -e removed intentionally: grep exits 1 when no lines match,
# which killed the script under set -e before Apache could start.

PORT="${PORT:-80}"

# Production-safe defaults for Docker/Railway. Local non-Docker is unchanged
# (index.php still defaults to debug/dev when these env vars are unset).
export YII_DEBUG="${YII_DEBUG:-false}"
export YII_ENV="${YII_ENV:-prod}"

echo "[entrypoint] PORT=$PORT YII_DEBUG=$YII_DEBUG YII_ENV=$YII_ENV"

# Patch Apache to listen on Railway's assigned PORT
sed -i "s/Listen 80/Listen ${PORT}/" /etc/apache2/ports.conf
sed -i "s/<VirtualHost \*:80>/<VirtualHost *:${PORT}>/" /etc/apache2/sites-enabled/000-default.conf

# Generate .env from Railway-injected env vars (only if not already present)
if [ ! -f /var/www/html/.env ]; then
    echo "[entrypoint] Writing .env from environment"
    printenv | grep -E '^(YII_DEBUG|YII_ENV|SYSTEM_TYPE|RESET_MENU_AT_LOGIN|ENABLE_POS_MODULES|DECIMAL_[A-Z_]+|QUERY_LIMITER|ENABLE_BRANCHADD|DB_HOST|DB_PORT|DB_USER|DB_PASS|DB_SCHEMA|DB_CHARSET|VERSION|RELEASE|LAST_MODIF_ATTR)=' \
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

# Force exactly one MPM at container start, not just at image build.
# Railway's deploy does not reliably apply file deletions between builds
# (mpm_event's symlinks from an old build were observed surviving
# alongside a freshly-built mpm_prefork), so enforce it here too where
# it runs against the container's actual live filesystem every start.
find /etc/apache2/mods-enabled -name 'mpm_*.conf' -o -name 'mpm_*.load' | xargs rm -f
ln -sf /etc/apache2/mods-available/mpm_prefork.conf /etc/apache2/mods-enabled/mpm_prefork.conf
ln -sf /etc/apache2/mods-available/mpm_prefork.load /etc/apache2/mods-enabled/mpm_prefork.load

echo "[entrypoint] mods-enabled MPM state:"
ls -la /etc/apache2/mods-enabled/ | grep -i mpm || echo "[entrypoint] (no mpm_* files found in mods-enabled)"
echo "[entrypoint] apache2ctl configtest at runtime:"
apache2ctl configtest 2>&1 || true

echo "[entrypoint] Starting Apache on port $PORT"
exec apache2-foreground
