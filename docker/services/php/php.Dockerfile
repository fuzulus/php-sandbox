ARG PHP_VERSION=8.1.8

FROM php:$PHP_VERSION-fpm-alpine

ARG USER_ID=1000
ARG GROUP_ID=1000

# Create app user and group with UID same as provided argument to avoid permission issues and conflicts
RUN addgroup -g "$GROUP_ID" -S app && adduser -S app -D -u $USER_ID -G app

# Install dependencies and utils
ENV RUNTIME_DEPS="icu-dev bash nano vim git libzip-dev zip unzip libpng-dev"
ENV BUILD_DEPS="m4 perl autoconf dpkg-dev dpkg libmagic file binutils libgomp libatomic libgphobos gmp isl22 mpfr4 mpc1 gcc musl-dev libc-dev g++ make re2c perl-error perl-git git-perl"

RUN apk add --update --no-cache $RUNTIME_DEPS
RUN apk add --update --no-cache $BUILD_DEPS

#Install ext dependencies
ENV EXT_DEPS='libsodium-dev libxml2-dev'
RUN apk add --update --no-cache $EXT_DEPS

RUN docker-php-ext-install intl zip gd opcache pcntl ctype pdo sodium xml dom pdo_mysql
RUN apk add php8-intl php8-zip php8-gd php8-opcache php8-session php8-pcntl php8-ctype php8-tokenizer php8-pdo \
  php8-pdo_mysql php8-pdo_sqlite php8-sodium  php8-xmlreader php8-xmlwriter php8-simplexml \
  php8-dom php8-pdo_mysql php8-fileinfo php8-ftp php8-sqlite3 php8-pecl-redis php8-xml php8-pecl-xdebug

# Install xdebug
RUN apk add --update linux-headers
RUN pecl install xdebug
RUN docker-php-ext-enable xdebug

ADD ./docker/services/php/xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini

ARG XDEBUG_ENABLED=true
RUN if [[ $XDEBUG_ENABLED = false ]]; then echo "xdebug.mode=off" > /usr/local/etc/php/conf.d/xdebug.ini; fi

# Remove build deps
RUN apk del --purge $BUILD_DEPS

# create app directory
RUN mkdir -p /opt/app && chown app /opt/app

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

USER app
WORKDIR /opt/app

ENV APP_ENV=dev

COPY --chown=app:app . .

RUN composer install -o