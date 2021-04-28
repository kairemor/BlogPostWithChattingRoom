FROM php:7.1.0-fpm

MAINTAINER kairemor <kairemor@gmail.com>

RUN apt-get update -y
RUN apt-get install -y nginx
RUN apt-get install -y autoconf pkg-config libssl-dev
RUN pecl install mongodb-1.2.2
RUN docker-php-ext-install bcmath
RUN echo "extension=mongodb.so" >> /usr/local/etc/php/conf.d/mongodb.ini

# Install Laravel dependencies
RUN apt-get install -y \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libmcrypt-dev \
        libpng12-dev

RUN docker-php-ext-install iconv mcrypt mbstring \
    && docker-php-ext-install zip \
    && docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ \
    && docker-php-ext-install gd

COPY nginx-site.conf /etc/nginx/sites-enabled/default
COPY entrypoint.sh /etc/entrypoint.sh
RUN chmod +x /etc/entrypoint.sh
RUN rm -r /var/www/html

WORKDIR /var/www/myapp

COPY . /var/www/myapp

EXPOSE 80 443

ENTRYPOINT ["/etc/entrypoint.sh"]

