FROM php:8.2-apache

# ServerName для Apache, чтобы убрать предупреждения
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Копируем проект
COPY . /var/www/html/

# Права доступа
RUN chown -R www-data:www-data /var/www/html && chmod -R 755 /var/www/html

# Открываем порт
EXPOSE 80
CMD ["apache2-foreground"]
