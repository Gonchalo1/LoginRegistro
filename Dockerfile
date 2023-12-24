
# Con esto (o una versión más reciente)
FROM docker.io/library/php:8.1-cli
# Establece el directorio de trabajo en /var/www/html
WORKDIR /var/www/html

# Copia el código de tu aplicación al contenedor
COPY . .

# Instala las dependencias de Laravel utilizando Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer install --no-dev --optimize-autoloader

# Exponer el puerto 8000 para el servidor de Laravel
EXPOSE 8000

# Iniciar el servidor de Laravel al arrancar el contenedor
CMD php artisan serve --host=0.0.0.0 --port=8000


# Instala el controlador de PostgreSQL
RUN apt-get update \
    && apt-get install -y libpq-dev \
    && docker-php-ext-install pdo_pgsql