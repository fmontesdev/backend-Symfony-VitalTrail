# Etapa de compilación
FROM php:8.3.21-fpm-alpine3.21

# Instalar dependencias de compilación y extensiones PHP necesarias
RUN apk add --no-cache \
    git \
    zip \
    unzip \
    oniguruma-dev \
    libxml2-dev \
    icu-dev \
    openssl-dev \
    postgresql-dev

# Instalar y configurar extensiones PHP
RUN docker-php-ext-install \
    pdo_pgsql \
    intl \
    mbstring \
    xml

# Instalar Composer globalmente
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Definir directorio de trabajo
WORKDIR /var/www/symfony_vitaltrail

# Copiar dependencias de Composer y optimizar caché
# Copiamos primero sólo composer.json y composer.lock para utilizar la cache de Docker
COPY composer.json composer.lock ./
RUN composer install --prefer-dist --no-scripts --no-interaction --optimize-autoloader

# Copiar el resto de la aplicación
COPY . ./

# Exponer el puerto para el servidor web integrado de PHP
EXPOSE 8000

# Iniciar el servidor web integrado de PHP
CMD ["php", "-S", "0.0.0.0:8000", "-t", "public/"]