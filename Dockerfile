FROM php:8.2-apache

# 1. Installa le dipendenze di sistema necessarie
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    libpq-dev \
    unzip \
    git \
    curl

# 2. Installa le estensioni PHP per Laravel e PostgreSQL
RUN docker-php-ext-install pdo pdo_pgsql mbstring zip exif pcntl

# 3. Installa Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 4. Abilita il modulo di riscrittura di Apache (fondamentale per Laravel)
RUN a2enmod rewrite

# 5. Imposta la directory di lavoro
WORKDIR /var/www/html

# 6. Copia tutti i file del progetto
COPY . .

# 7. Installa le dipendenze PHP (senza quelle di sviluppo)
RUN composer install --no-dev --optimize-autoloader

# 8. FIX CRITICO: Imposta la cartella 'public' di Laravel come root di Apache
RUN sed -i 's|DocumentRoot /var/www/html|DocumentRoot /var/www/html/public|g' /etc/apache2/sites-available/000-default.conf

# 9. FIX CRITICO: Permetti a Laravel di usare il file .htaccess per le rotte
RUN printf '<Directory /var/www/html/public>\n\tAllowOverride All\n\tRequire all granted\n</Directory>\n' >> /etc/apache2/apache2.conf

# 10. Imposta i permessi corretti per Laravel
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage \
    && chmod -R 755 /var/www/html/bootstrap/cache

# 11. FIX CRITICO PER RENDER: Crea uno script che adatta la porta di Apache alla porta dinamica di Render
RUN printf '#!/bin/bash\n\
export PORT=${PORT:-80}\n\
sed -i "s/Listen 80/Listen $PORT/g" /etc/apache2/ports.conf\n\
sed -i "s/<VirtualHost \*:80>/<VirtualHost *:$PORT>/g" /etc/apache2/sites-available/000-default.conf\n\
apache2-foreground\n' > /start.sh && chmod +x /start.sh

# 12. Avvia lo script
CMD ["/start.sh"]