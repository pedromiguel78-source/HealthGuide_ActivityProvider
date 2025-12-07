FROM php:8.2-apache

# Copiar código para o container
COPY . /var/www/html/

# Habilitar mod_rewrite e mod_headers
RUN a2enmod rewrite headers

# Configurar Apache para permitir .htaccess
RUN sed -i '/<Directory \/var\/www\/>/,/<\/Directory>/ s/AllowOverride None/AllowOverride All/' /etc/apache2/apache2.conf

# Configurar permissões
RUN chown -R www-data:www-data /var/www/html

# Verificar que .htaccess existe
RUN ls -la /var/www/html/.htaccess || echo "WARNING: .htaccess não encontrado!"

EXPOSE 80

CMD ["apache2-foreground"]
