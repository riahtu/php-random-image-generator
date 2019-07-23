FROM survivorbat/php7.4-composer

# TODO: Add multi-stage build (if needed)

USER root

RUN apk add --no-cache \
    libpng \
    libpng-dev \
    php7-gd \
    && docker-php-ext-install gd

USER php

COPY --chown=php:php . /app/

RUN composer install -d /app/src --optimize-autoloader --ignore-platform-reqs --no-interaction --no-suggest \
    && /app/src/vendor/bin/phpunit /app/src/tests

WORKDIR /app/src/bin
