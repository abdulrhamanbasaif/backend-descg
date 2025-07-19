# Stage 1: Build React frontend
FROM node:20 AS frontend-build
WORKDIR /app/frontend
COPY ./frontend/package.json ./frontend/package-lock.json ./
RUN npm install
COPY ./frontend .
RUN npm run build

# Stage 2: Set up Laravel backend
FROM php:8.2-fpm-alpine AS backend
WORKDIR /var/www/html

# Install PHP extensions
RUN apk add --no-cache \
    nginx \
    bash \
    php82-mbstring \
    php82-pdo_mysql \
    php82-tokenizer \
    php82-xml \
    php82-curl \
    php82-fileinfo \
    php82-openssl \
    php82-bcmath \
    php82-ctype \
    php82-json \
    php82-exif \
    php82-pcntl \
    php82-simplexml \
    php82-session \
    php82-zip \
    php82-intl \
    php82-dom \
    php82-iconv \
    php82-phar \
    php82-gd \
    php82-soap \
    php82-sockets \
    php82-pdo_pgsql \
    php82-pgsql \
    php82-sodium \
    php82-pdo_sqlite \
    php82-sqlite3 \
    php82-xmlwriter \
    php82-xsl \
    php82-mysqli \
    php82-imap \
    php82-pecl-imagick \
    php82-pecl-memcached \
    php82-pecl-redis \
    php82-opcache \
    php82-posix \
    php82-shmop \
    php82-sysvmsg \
    php82-sysvsem \
    php82-sysvshm \
    php82-xmlreader \
    php82-xdebug \
    php82-memcache \
    php82-gmp \
    php82-pecl-xdebug \
    php82-pdo_odbc \
    php82-odbc \
    php82-enchant \
    php82-dba

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy Laravel app
COPY ./backend /var/www/html

# Install Laravel dependencies
RUN composer install --no-dev --optimize-autoloader
RUN php artisan key:generate
RUN php artisan config:cache
RUN php artisan route:cache
RUN php artisan view:cache

# Copy built React to Laravel's public directory
COPY --from=frontend-build /app/frontend/dist /var/www/html/public

# Configure Nginx
COPY ./docker/nginx.conf /etc/nginx/nginx.conf

# Expose port 8080
EXPOSE 8080

# Start both PHP-FPM and Nginx
CMD ["sh", "-c", "php-fpm -D && nginx -g 'daemon off;'"]
