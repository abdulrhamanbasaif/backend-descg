
# Laravel backend only
FROM php:8.2-fpm-alpine

# Install system deps + PHP extensions
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

# Force php-fpm to listen on TCP 9000, not socket
RUN sed -i 's|listen = .*|listen = 9000|' /usr/local/etc/php-fpm.d/www.conf



# Copy Laravel backend files
WORKDIR /var/www/html
COPY . /var/www/html


# Install Laravel dependencies
RUN composer install --no-dev --optimize-autoloader


# Copy Nginx config
COPY docker/nginx.conf /etc/nginx/nginx.conf


# Fix permissions for Laravel storage & cache
RUN chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache


# Expose Railway required port
EXPOSE 80


# Run Laravel caches + Nginx + PHP-FPM
CMD ["sh", "-c", "php artisan migrate --force && php artisan config:cache && php artisan route:cache && php artisan view:cache && php-fpm -D && nginx -g 'daemon off;'"]
