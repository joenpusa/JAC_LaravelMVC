# Usar una imagen base oficial de PHP con Apache
FROM php:8.1-apache

# Instalar extensiones necesarias para Laravel
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    libpq-dev \
    && docker-php-ext-install pdo pdo_mysql zip

# Instalar Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Configurar el directorio de trabajo
WORKDIR /var/www/html

# Copiar el código fuente al contenedor
COPY . .

# Establecer permisos para el almacenamiento y el cache
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Habilitar el módulo Rewrite de Apache
RUN a2enmod rewrite

# Configuración del puerto para Apache
EXPOSE 8085
