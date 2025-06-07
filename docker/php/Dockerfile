FROM php:8.2-apache

# Instalar mysqli y otras dependencias necesarias
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Copiar configuración de subida
COPY uploads.ini /usr/local/etc/php/conf.d/
