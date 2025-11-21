FROM php:8.2-apache

# Instalando extensões necessárias
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Habilitar mod_rewrite
RUN a2enmod rewrite

# Copiar backend para o diretório padrão do Apache
COPY . /var/www/html/

# Permissões
RUN chown -R www-data:www-data /var/www/html