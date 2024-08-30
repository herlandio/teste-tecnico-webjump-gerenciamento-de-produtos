FROM php:7.4-apache

WORKDIR /var/www/html

COPY ./ /var/www/html

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN apt-get update \ 
    && apt-get install -y unzip p7zip-full \
    && docker-php-ext-install pdo pdo_mysql mysqli \
    && a2enmod rewrite \
    && echo "ServerName localhost" >> /etc/apache2/apache2.conf \
    && composer install

EXPOSE 8000
