# Stage 1: Install Composer separately
FROM php:8.2-cli-alpine AS composer
RUN apk add --no-cache curl
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer

# Stage 2: Laravel backend only
FROM php:8.2-fpm-alpine

# Install system dependencies and PHP extensions
RUN apk add --no-cache \
    nginx \
    bash \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    libzip-dev \
    zip \
    curl \
    oniguruma-dev \
    icu-dev \
    zlib-dev \
    libxml2-dev \
    sqlite-dev \
    git \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_mysql mysqli zip intl gd xml opcache bcmath

# Force php-fpm to listen on TCP port 9000
RUN sed -i 's|listen = .*|listen = 9000|' /usr/local/etc/php-fpm.d/www.conf

# Copy Composer from first stage
COPY --from=composer /usr/bin/composer /usr/bin/composer

# Set working directory and copy all Laravel files
WORKDIR /var/www/html
COPY . /var/www/html

# Install Laravel dependencies
RUN composer install --no-dev --optimize-autoloader

# Set permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Copy Nginx configuration
COPY ./docker/nginx.conf /etc/nginx/nginx.conf

# Expose Railway required port
EXPOSE 8080

# Start app: Laravel cache + php-fpm + nginx
CMD ["sh", "-c", "php artisan config:clear && php artisan route:clear && php artisan view:clear && php artisan migrate --force && php artisan config:cache && php artisan route:cache && php artisan view:cache && php-fpm -D && nginx -g 'daemon off;'"]
