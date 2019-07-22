FROM survivorbat/php7.4-composer

USER root

RUN apk add --no-cache \
    libpng \
    libpng-dev \
    php7-gd \
    && docker-php-ext-install gd

USER php

COPY --chown=php:php . /app/

RUN composer install --optimize-autoloader --ignore-platform-reqs --no-interaction --no-suggest \
    && /app/src/vendor/bin/phpunit /app/src/tests

CMD ["bin/console img:create:random"]

