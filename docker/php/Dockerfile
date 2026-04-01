FROM php:8.4-fpm-alpine

COPY --from=mlocati/php-extension-installer \
     /usr/bin/install-php-extensions \
     /usr/local/bin/

RUN apk add --no-cache \
    bash \
    git \
    unzip \
    zip \
    curl \
    supervisor


RUN install-php-extensions \
    pdo_pgsql \
    bcmath \
    pcntl \
    sockets \
    opcache \
    intl \
    redis \
    amqp \
    xdebug

COPY --from=composer:2 /usr/bin/composer /usr/local/bin/composer

ENV COMPOSER_ALLOW_SUPERUSER=1

WORKDIR /var/www/html

COPY composer.json composer.lock ./
RUN composer install --no-scripts --no-autoloader

COPY . .
RUN composer dump-autoload --optimize

COPY ./docker/supervisor/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

RUN chown -R www-data:www-data /var/www/html

EXPOSE 9000

CMD ["supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]