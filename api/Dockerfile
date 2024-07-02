# Používame oficiálny PHP image s verziou 8.2
FROM php:8.2-fpm

# Nastavenie pracovného adresára
WORKDIR /var/www

ENV COMPOSER_ALLOW_SUPERUSER=1

# Inštalácia závislostí systému
RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    locales \
    zip \
    jpegoptim optipng pngquant gifsicle \
    vim \
    unzip \
    git \
    curl \
    libpq-dev \
    libzip-dev

# Inštalácia PHP rozšírení
RUN docker-php-ext-install pdo pdo_pgsql
RUN docker-php-ext-configure gd --with-freetype --with-jpeg
RUN docker-php-ext-install gd
RUN pecl install redis \
    && docker-php-ext-enable redis

# Inštalácia Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Kopírovanie celej aplikácie
COPY . /var/www

# Inštalácia závislostí
RUN composer install

# Nastavenie práv pre Laravel
RUN chown -R www-data:www-data /var/www \
    && chmod -R 775 /var/www/storage \
    && chmod -R 775 /var/www/bootstrap/cache

# Exponovanie portu
EXPOSE 9000

# Spustenie PHP-FPM serveru
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=9000"]
