FROM nginx:1.23.3-alpine as nginx

COPY ./public/ /usr/src/app/public/

COPY ./docker/nginx/default.conf /etc/nginx/conf.d/default.conf

##################################

FROM composer:2.5.4 AS composer

##################################

FROM composer AS vendor-dev

WORKDIR /usr/src/app

COPY --chown=1000 ./composer.* ./
COPY --chown=1000 ./symfony.lock ./

RUN composer install \
        --ignore-platform-reqs \
        --no-cache \
        --no-interaction \
        --no-scripts \
        --prefer-dist

##################################

FROM php:8.1.16-fpm-buster

SHELL ["/bin/bash", "-o", "pipefail", "-c"]

RUN apt-get update \
 && apt-get install -y --no-install-recommends \
        git=1:2.20.1-2+deb10u3 \
        libicu-dev=63.1-6+deb10u3 \
        unzip=6.0-23+deb10u2 \
        wget=1.20.1-1.1 \
 && docker-php-ext-install \
        intl \
        pdo_mysql \
 && rm -rf /tmp/pear \
 && apt-get remove -y \
        wget \
 && rm -rf /var/lib/apt/lists/*

COPY --from=composer /usr/bin/composer /usr/bin/composer

ENV COMPOSER_CACHE_DIR=/dev/null

CMD ["php-fpm"]

WORKDIR /usr/src/app

RUN chown -R 1000 /usr/src/app

USER 1000

ENV APP_ENV=dev
ENV APP_DEBUG=1

COPY --chown=1000 . /usr/src/app
COPY --chown=1000 --from=vendor-dev /usr/src/app/vendor /usr/src/app/vendor

RUN composer check-platform-reqs

USER 0

RUN mv "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini" \
 && cp ./docker/php/php.ini "$PHP_INI_DIR/conf.d/custom.ini"

USER 1000

RUN composer run-script post-install-cmd
