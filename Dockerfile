FROM php:8.2-apache

# Copiar código para o container
COPY . /var/www/html/

# Habilitar mod_rewrite
RUN a2enmod rewrite

# Configurar permissões
RUN chown -R www-data:www-data /var/www/html

EXPOSE 80

CMD ["apache2-foreground"]
