FROM survivorbat/php7.4-composer

USER root

RUN apk add --no-cache \
    libpng \
    libpng-dev \
    php7-gd \
    && docker-php-ext-install gd

USER php

# TODO: Add labels
