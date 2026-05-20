#!/bin/bash
set -e

echo "=== Starting Dak Ghar Export Portal ==="

# 1. Ensure .env file exists (Laravel requires it)
if [ ! -f /var/www/html/.env ]; then
    echo ">>> Creating .env from .env.example..."
    cp /var/www/html/.env.example /var/www/html/.env
fi

# 2. Inject environment variables into .env (Render passes them as OS env vars)
# Override key values from Render's environment variables if they are set
if [ -n "$APP_KEY" ]; then
    sed -i "s|^APP_KEY=.*|APP_KEY=${APP_KEY}|" /var/www/html/.env
fi
sed -i "s|^APP_ENV=.*|APP_ENV=production|" /var/www/html/.env
sed -i "s|^APP_DEBUG=.*|APP_DEBUG=false|" /var/www/html/.env
sed -i "s|^DB_CONNECTION=.*|DB_CONNECTION=sqlite|" /var/www/html/.env
sed -i "s|^SESSION_DRIVER=.*|SESSION_DRIVER=file|" /var/www/html/.env
sed -i "s|^CACHE_STORE=.*|CACHE_STORE=file|" /var/www/html/.env
sed -i "s|^QUEUE_CONNECTION=.*|QUEUE_CONNECTION=sync|" /var/www/html/.env

# If APP_URL is provided by Render (via RENDER_EXTERNAL_URL), set it
if [ -n "$RENDER_EXTERNAL_URL" ]; then
    sed -i "s|^APP_URL=.*|APP_URL=${RENDER_EXTERNAL_URL}|" /var/www/html/.env
fi

echo ">>> .env configured for production."

# 3. Ensure SQLite database file exists
touch /var/www/html/database/database.sqlite
echo ">>> SQLite database file ready."

# 4. Ensure storage directories exist
mkdir -p /var/www/html/storage/framework/sessions
mkdir -p /var/www/html/storage/framework/views
mkdir -p /var/www/html/storage/framework/cache/data
mkdir -p /var/www/html/storage/logs

# 5. Clear any stale caches from build phase
cd /var/www/html
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
echo ">>> Caches cleared."

# 6. Run migrations
php artisan migrate --force
echo ">>> Migrations complete."

# 7. Seed database
php artisan db:seed --force
echo ">>> Database seeded."

# 8. Cache config and routes for production performance
php artisan config:cache
php artisan route:cache
php artisan view:cache
echo ">>> Production caches built."

# 9. Fix ALL permissions for www-data (Apache user)
chown -R www-data:www-data /var/www/html/storage
chown -R www-data:www-data /var/www/html/database
chown -R www-data:www-data /var/www/html/bootstrap/cache
chmod -R 775 /var/www/html/storage
chmod -R 775 /var/www/html/database
chmod -R 775 /var/www/html/bootstrap/cache
echo ">>> Permissions set for www-data."

echo "=== Starting Apache ==="
exec apache2-foreground
