FROM php:8.2-fpm

# Instalar dependências
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    nodejs \
    npm

# Instalar extensões PHP (incluindo Redis)
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd sockets

# Instalar Redis extension
RUN pecl install redis && docker-php-ext-enable redis

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Instalar Laravel Installer
RUN composer global require laravel/installer
ENV PATH="${PATH}:/root/.composer/vendor/bin"

WORKDIR /var/www

# Configurar permissões
RUN chown -R www-data:www-data /var/www
RUN chmod -R 755 /var/www