FROM php:8.1.0-fpm-alpine AS ext-amqp

ENV EXT_AMQP_VERSION=master

RUN docker-php-source extract \
    && apk -Uu add git rabbitmq-c-dev \
    && git clone --branch $EXT_AMQP_VERSION --depth 1 https://github.com/php-amqp/php-amqp.git /usr/src/php/ext/amqp \
    && cd /usr/src/php/ext/amqp && git submodule update --init \
    && docker-php-ext-install amqp

RUN ls -al /usr/local/lib/php/extensions/

FROM node:latest
RUN npm install -g npm@9.4.2
RUN npm install -g yarn
RUN yarn build

FROM php:8.1.0-fpm-alpine

COPY --from=ext-amqp /usr/local/etc/php/conf.d/docker-php-ext-amqp.ini /usr/local/etc/php/conf.d/docker-php-ext-amqp.ini
COPY --from=ext-amqp /usr/local/lib/php/extensions/no-debug-non-zts-20210902/amqp.so /usr/local/lib/php/extensions/no-debug-non-zts-20210902/amqp.so

RUN set -ex \
  && apk --no-cache add \
    postgresql-dev \
    rabbitmq-c-dev \
    rabbitmq-c \
    supervisor \
    libzip-dev \
    bash \
    wget

#RUN apk add --no-cache pcre-dev $PHPIZE_DEPS \
        #&& pecl install redis \
       # && docker-php-ext-enable redis.so


RUN docker-php-ext-install pdo pdo_pgsql

RUN apk add --update linux-headers

RUN apk add --no-cache --virtual .build-deps $PHPIZE_DEPS \
    && pecl install xdebug-3.2.0 \
    && docker-php-ext-enable xdebug \
    && apk del -f .build-deps

RUN echo "xdebug.start_with_request=yes" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.mode=debug" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.log=/var/www/html/xdebug/xdebug.log" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.discover_client_host=1" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.client_port=9000" >> /usr/local/etc/php/conf.d/xdebug.ini

RUN apk --update --no-cache add autoconf g++ make && \
     pecl install -f pcov && \
     docker-php-ext-enable pcov && \
     apk del --purge autoconf g++ make

RUN wget https://get.symfony.com/cli/installer -O - | bash
RUN curl -sL https://getcomposer.org/installer | php -- --install-dir /usr/bin --filename composer

RUN mkdir -p /var/log/supervisor

WORKDIR /app

RUN echo 'pm.max_children = 30' >> /usr/local/etc/php-fpm.d/zz-docker.conf

RUN docker-php-ext-configure opcache --enable-opcache \
    && docker-php-ext-install opcache

CMD ["php-fpm"]