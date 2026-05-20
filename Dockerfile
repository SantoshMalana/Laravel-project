# Stage 1: Build Frontend Assets
FROM node:22 AS node-builder
WORKDIR /app
COPY package*.json ./
RUN npm install
COPY . .
RUN npm run build

# Stage 2: Main PHP Apache Runtime
FROM php:8.2-apache

# Install system dependencies
RUN apt-get update && apt-get install -y \
    zip \
    unzip \
    git \
    libsqlite3-dev \
    && rm -rf /var/lib/apt/lists/*

# Install PHP extensions (ensure pdo_sqlite is available)
RUN docker-php-ext-install pdo pdo_sqlite

# Enable Apache Rewrite Module (required for Laravel routing)
RUN a2enmod rewrite

# Configure Apache: Set DocumentRoot AND enable AllowOverride for .htaccess
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# CRITICAL: Enable AllowOverride All so Laravel's .htaccess rewrite rules work
RUN sed -ri -e 's/AllowOverride None/AllowOverride All/g' /etc/apache2/apache2.conf

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy project files
COPY . .

# Copy compiled frontend assets from node-builder stage
COPY --from=node-builder /app/public/build ./public/build

# Install PHP dependencies (with dummy .env so artisan package:discover works)
RUN cp .env.example .env \
    && composer install --no-dev --optimize-autoloader \
    && rm .env

# Create SQLite database file and required storage directories
RUN mkdir -p database \
    && touch database/database.sqlite \
    && mkdir -p storage/framework/sessions \
    && mkdir -p storage/framework/views \
    && mkdir -p storage/framework/cache/data \
    && mkdir -p storage/logs \
    && mkdir -p bootstrap/cache

# Set permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 /var/www/html/storage \
    && chmod -R 775 /var/www/html/bootstrap/cache \
    && chmod -R 775 /var/www/html/database

# Copy and prepare entrypoint script
COPY docker-entrypoint.sh /usr/local/bin/docker-entrypoint.sh
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

EXPOSE 80

# Use the entrypoint script to handle migrations, permissions, and startup
CMD ["/usr/local/bin/docker-entrypoint.sh"]
