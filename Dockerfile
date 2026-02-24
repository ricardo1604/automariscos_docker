# Usamos PHP 8.0 con Apache (compatible con mysqli)
FROM php:8.0-apache

# Instalar extensión mysqli (necesaria para tu clase conectar)
RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli

# Habilitar mod_rewrite de Apache (común en apps legacy para URLs amigables)
RUN a2enmod rewrite

# Copiar el código al contenedor
COPY . /var/www/html/

# Dar permisos al usuario www-data (el usuario de Apache)
RUN chown -R www-data:www-data /var/www/html
