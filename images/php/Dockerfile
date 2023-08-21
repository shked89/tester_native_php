FROM php:8.1-fpm

# RUN apt-get update && \
#     apt-get install -y zip curl libcurl3-dev libzip-dev libpng-dev libonig-dev libxml2-dev

# RUN docker-php-ext-install curl gd mbstring mysqli pdo pdo_mysql xml

RUN apt-get update && \
    apt-get install -y libpq-dev && \
    apt-get install -y zip curl libcurl3-dev libzip-dev libpng-dev libonig-dev libxml2-dev

RUN docker-php-ext-install curl gd mbstring mysqli pdo pdo_mysql xml


RUN docker-php-ext-install sockets 
RUN docker-php-ext-enable sockets mysqli pdo pdo_mysql


WORKDIR /var/www

# EXPOSE 9000

# COPY ./images/php/mariadb.cnf /etc/mysql/mariadb.cnf

# RUN apt-get update && \
#     apt-get install -y libpq-dev && \
#     docker-php-ext-install pdo pdo_mysql && \
#     pecl install sockets && \
#     docker-php-ext-enable sockets pdo_mysql


# CMD ["apache2-foreground"]
# CMD ["php-fpm"]
# CMD [ "php" ]

