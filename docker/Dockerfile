FROM php:8.1-fpm

WORKDIR /var/www/app

RUN apt-get update && apt-get install -y \
    build-essential \
    libonig-dev \
    libpng-dev \
    libwebp-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    locales \
    zip \
    jpegoptim optipng pngquant gifsicle \
    vim \
    unzip \
    git \
    curl \
    libzip-dev
#RUN apt-get install -y \
#    nodejs \
#    npm
RUN apt-get clean && rm -rf /var/lib/apt/lists/*
RUN docker-php-ext-install pdo_mysql mbstring zip exif pcntl
RUN docker-php-ext-configure gd --prefix=/usr --with-jpeg --with-webp --with-freetype
RUN docker-php-ext-install gd

COPY . /var/www/app
RUN cp ./.env.example ./.env
RUN rm -rf ./.git
RUN rm -rf ./.idea

RUN groupadd -g 1000 www
RUN useradd -u 1000 -ms /bin/bash -g www www
RUN chmod 775 $(find /var/www/app/ -type d)
RUN chmod 664 $(find /var/www/app/ -type f)
RUN chmod 774 /var/www/app/docker/cmd.sh
RUN chown www:www -R /var/www/app/

USER www

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/var/www/app
RUN php composer.phar install

#RUN npm install
#RUN npm run prod

#RUN rm -rf ./node_modules

RUN php artisan key:generate
RUN php artisan config:cache
RUN php artisan route:cache

EXPOSE 9000
CMD ["/var/www/app/docker/cmd.sh"]
