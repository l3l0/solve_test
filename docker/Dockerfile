FROM php:7.3-rc-cli

RUN apt-get update
RUN apt-get -y install git unzip wget zlib1g-dev libpq-dev libzip-dev libicu-dev wget gnupg

RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" && php composer-setup.php && mv composer.phar /usr/local/bin/composer
RUN docker-php-ext-install zip pdo pdo_pgsql opcache intl sockets

