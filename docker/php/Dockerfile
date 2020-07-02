# See https://github.com/docker-library/php/blob/master/7.1/fpm/Dockerfile
FROM php:7.2-fpm

RUN buildDeps="libpq-dev libzip-dev libzip4 libicu-dev libpng-dev libjpeg62-turbo-dev libfreetype6-dev libmagickwand-6.q16-dev sudo git zip unzip zip unzip git sudo" && \
    apt-get update && \
    apt-get install -y $buildDeps --no-install-recommends && \
    ln -s /usr/lib/x86_64-linux-gnu/ImageMagick-6.8.9/bin-Q16/MagickWand-config /usr/bin && \
    pecl install imagick && \
    echo "extension=imagick.so" > /usr/local/etc/php/conf.d/ext-imagick.ini && \
    apt-get clean && \
    rm -rf /var/lib/apt/lists/* && \
    docker-php-ext-install \
        opcache \
        pdo \
        pdo_pgsql \
        pgsql \
        sockets \
        intl \
        bcmath

# for xdebug 2.7 or > need use PHPSTORM >=2018.2
RUN pecl install xdebug-2.6.1 \
    && docker-php-ext-enable xdebug

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer --version

RUN apt-get update
RUN apt-get install ssh -y
RUN apt-get install nano -y

RUN mkdir -p ~/.ssh
RUN touch ~/.ssh/authorized_keys


RUN docker-php-ext-install gd
RUN docker-php-ext-install exif

WORKDIR /var/www/html

CMD ["php-fpm"]