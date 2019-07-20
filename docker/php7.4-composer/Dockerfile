FROM php:7.4.0alpha3-cli-alpine

COPY --from=composer /usr/bin/composer /usr/bin/composer

RUN addgroup -g 1000 php \
    && adduser -u 1000 -s /bin/sh -S php \
    && mkdir -p /app \
    && chown -R php:php /app \
    && apk add --update --no-cache --virtual \
       git

WORKDIR /app

USER php

ENTRYPOINT ["/usr/local/bin/php"]
