# Используем официальный образ PHP 7.2
FROM php:7.2-apache

# Установка необходимых расширений PHP
RUN docker-php-ext-install pdo pdo_mysql

# Копируем исходный код приложения в контейнер
COPY . /var/www/html

# Указываем рабочую директорию
WORKDIR /var/www/html

# Устанавливаем права на директорию для Apache
RUN chown -R www-data:www-data /var/www/html

# Опционально: настройка PHP (например, если нужно изменить php.ini)
# COPY php.ini /usr/local/etc/php/
