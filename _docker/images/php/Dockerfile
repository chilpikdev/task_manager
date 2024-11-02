FROM php:8.3-fpm

RUN apt-get update && apt-get install -y \
    apt-utils \
    libpq-dev \
    libpng-dev \
    postgresql \
    libjpeg-dev \
    libzip-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libmcrypt-dev \
    libgd-dev \
    jpegoptim optipng pngquant gifsicle \
    libonig-dev \
    libxml2-dev \
    zip unzip \
    git && \
    docker-php-ext-install pdo_pgsql bcmath gd zip && \
    docker-php-ext-install intl && \
    docker-php-ext-configure intl && \
    apt-get clean

WORKDIR /var/www

RUN docker-php-ext-configure gd --enable-gd --with-freetype --with-jpeg

COPY ./_docker/images/php/conf.d/php.ini /usr/local/etc/php/conf.d/php.ini

RUN curl -sS https://getcomposer.org/installer | php -- \
    --install-dir=/usr/local/bin --filename=composer

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# COPY ../../../ /var/www

RUN chown -R root:www-data /var/www \
    && chmod -R 755 /var/www/

USER root

EXPOSE 9000

CMD ["php-fpm"]
