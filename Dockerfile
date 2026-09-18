FROM php:8.2-apache

# Installa le estensioni necessarie per Laravel e PostgreSQL
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    libpq-dev \
    unzip \
    git \
    curl

RUN docker-php-ext-install pdo pdo_pgsql mbstring zip exif pcntl

# Installa Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Abilita mod_rewrite di Apache (necessario per Laravel)
RUN a2enmod rewrite

# Imposta la directory di lavoro
WORKDIR /var/www/html

# Copia tutti i file del progetto
COPY . .

# Installa le dipendenze PHP
RUN composer install --no-dev --optimize-autoloader

# Configura i permessi per Laravel
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage \
    && chmod -R 755 /var/www/html/bootstrap/cache

# Espone la porta 80
EXPOSE 80

# Avvia Apache
CMD ["apache2-foreground"]