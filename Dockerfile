FROM php:7.3-apache
RUN docker-php-ext-install mysqli pdo pod_mysql && docker-php-ext-enable mysqli
RUN a2enmod rewrite
RUN apt-get update && apt-get upgrade -y