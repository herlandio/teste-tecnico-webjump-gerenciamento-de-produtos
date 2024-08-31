FROM php:7.4-apache

WORKDIR /var/www/html

COPY ./ /var/www/html

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN apt-get update \ 
    && apt-get install -y unzip p7zip-full \
    && docker-php-ext-install pdo pdo_mysql mysqli \
    && a2enmod rewrite \
    && a2enmod headers \
    && echo "ServerName localhost" >> /etc/apache2/apache2.conf \
    && echo '<IfModule mod_headers.c>\n\
                Header set Access-Control-Allow-Origin "*"\n\
                Header set Access-Control-Allow-Methods "GET, POST, PUT, DELETE, OPTIONS"\n\
                Header set Access-Control-Allow-Headers "Origin, Content-Type, Accept, Authorization"\n\
            </IfModule>\n'\
    >> /etc/apache2/conf-enabled/cors.conf
    
EXPOSE 8000
