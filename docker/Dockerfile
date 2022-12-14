# syntax=docker/dockerfile:1
FROM php:8.1-fpm

ENV COMPOSER_ALLOW_SUPERUSER 1

RUN apt-get update \
  && apt-get install -y curl postgresql postgresql-contrib \
  && apt-get install sudo \
  && apt-get install -y libpq-dev \
  && docker-php-ext-install pdo pdo_pgsql

#RUN apt-get clean && rm -rf /var/lib/apt/lists/*

RUN apt-get install --no-install-recommends --no-install-suggests -y nginx nodejs npm
RUN apt-get install --no-install-recommends --no-install-suggests -y git
RUN apt-get install --no-install-recommends --no-install-suggests -y libzip-dev zip unzip

WORKDIR /app
COPY . .

RUN php ./composer.phar install --prefer-dist --ignore-platform-reqs --no-dev
RUN npm install
RUN npm run prod

RUN php artisan key:generate

COPY /docker/nginx.conf /etc/nginx/sites-available/default

CMD ["/usr/sbin/nginx", "-g", "daemon off;"]

EXPOSE 80/tcp
