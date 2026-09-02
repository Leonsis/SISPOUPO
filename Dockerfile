FROM php:8.3-apache

# Instala dependências do sistema necessárias para o PHP
RUN apt-get update \
    && apt-get install -y \
        libzip-dev \
        unzip \
        git \
    && docker-php-ext-install \
        pdo \
        pdo_mysql \
        zip \
    && rm -rf /var/lib/apt/lists/*

# Habilita o mod_rewrite do Apache
RUN a2enmod rewrite

# Instala o Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copia os arquivos do projeto
COPY . .

# Instala as dependências do Laravel
RUN composer install \
    --no-interaction \
    --prefer-dist \
    --optimize-autoloader

# Garante que os diretórios necessários existam
RUN mkdir -p storage/logs bootstrap/cache

# Permissões necessárias para o Laravel
RUN chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

# Permissões gerais
RUN chown -R www-data:www-data /var/www/html