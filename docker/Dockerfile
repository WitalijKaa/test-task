FROM php:8.1-fpm

COPY composer.lock composer.json /var/www/app/

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
RUN apt-get clean && rm -rf /var/lib/apt/lists/*
RUN docker-php-ext-install pdo_mysql mbstring zip exif pcntl
RUN docker-php-ext-configure gd --prefix=/usr --with-jpeg --with-webp --with-freetype
RUN docker-php-ext-install gd

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN groupadd -g 1000 www
RUN useradd -u 1000 -ms /bin/bash -g www www

COPY . /var/www/app

RUN chmod 774 $(find /var/www/app/ -type d)
RUN chmod 664 $(find /var/www/app/ -type f)
RUN chown www:www -R /var/www/app/

USER www

EXPOSE 9000
CMD ["php-fpm"]
