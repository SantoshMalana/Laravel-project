#!/bin/bash
set -e

echo "=== Starting Dak Ghar Export Portal ==="

# 1. Generate a clean .env file directly (no sed, no parsing issues)
cat > /var/www/html/.env << ENVFILE
APP_NAME="Dak Ghar Export Portal"
APP_ENV=production
APP_KEY=${APP_KEY:-base64:O0jg3qdKd57pC7VyZvTNVL0ERzjAO4haN8LsiW3e5K8=}
APP_DEBUG=false
APP_URL=${RENDER_EXTERNAL_URL:-http://localhost}

APP_LOCALE=en
APP_FALLBACK_LOCALE=en
APP_FAKER_LOCALE=en_US
APP_MAINTENANCE_DRIVER=file

BCRYPT_ROUNDS=12

LOG_CHANNEL=stack
LOG_STACK=single
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=error

DB_CONNECTION=sqlite

SESSION_DRIVER=file
SESSION_LIFETIME=120
SESSION_ENCRYPT=false
SESSION_PATH=/
SESSION_DOMAIN=null

BROADCAST_CONNECTION=log
FILESYSTEM_DISK=local
QUEUE_CONNECTION=sync

CACHE_STORE=file

MAIL_MAILER=log

VITE_APP_NAME="Dak Ghar Export Portal"
ENVFILE

echo ">>> .env file created for production."

# 2. Ensure SQLite database file exists
touch /var/www/html/database/database.sqlite
echo ">>> SQLite database file ready."

# 3. Ensure storage directories exist
mkdir -p /var/www/html/storage/framework/sessions
mkdir -p /var/www/html/storage/framework/views
mkdir -p /var/www/html/storage/framework/cache/data
mkdir -p /var/www/html/storage/logs
mkdir -p /var/www/html/bootstrap/cache

# 4. Clear any stale caches from build phase
cd /var/www/html
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
echo ">>> Caches cleared."

# 5. Run migrations
php artisan migrate --force
echo ">>> Migrations complete."

# 6. Seed database
php artisan db:seed --force
echo ">>> Database seeded."

# 7. Cache config and routes for production performance
php artisan config:cache
php artisan route:cache
php artisan view:cache
echo ">>> Production caches built."

# 8. Fix ALL permissions for www-data (Apache user)
chown -R www-data:www-data /var/www/html/storage
chown -R www-data:www-data /var/www/html/database
chown -R www-data:www-data /var/www/html/bootstrap/cache
chmod -R 775 /var/www/html/storage
chmod -R 775 /var/www/html/database
chmod -R 775 /var/www/html/bootstrap/cache
echo ">>> Permissions set for www-data."

echo "=== Starting Apache ==="
exec apache2-foreground
