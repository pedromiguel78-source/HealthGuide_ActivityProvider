FROM php:8.2-apache

# Copiar código para o container
COPY . /var/www/html/

# Habilitar mod_rewrite
RUN a2enmod rewrite

# Configurar permissões
RUN chown -R www-data:www-data /var/www/html

# Permitir htaccess e override
RUN echo "<Directory /var/www/html/> \
        AllowOverride All \
        Require all granted \
    </Directory>" > /etc/apache2/conf-available/rewrite.conf \
    && a2enconf rewrite

# Forçar Apache a usar index.php como root
RUN echo "DirectoryIndex index.php" >> /etc/apache2/apache2.conf

EXPOSE 80

CMD ["apache2-foreground"]

