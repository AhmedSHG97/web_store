FROM php:8.0-fpm


RUN apt-get update && apt-get install -y libzip-dev \
        libpng-dev \
        zlib1g-dev \
        curl \
        build-essential \
        libssl-dev \
        libfreetype6-dev \
        nano \
        libjpeg62-turbo-dev \
        libpng-dev \
        libmcrypt-dev \
        libicu-dev \
        libxml2-dev \
        libwebp-dev \
        zlib1g-dev \
        zip \
        unzip


RUN docker-php-ext-install zip \
    && docker-php-ext-configure gd --with-freetype=/usr/include/ --with-jpeg=/usr/include/ \
    && docker-php-ext-install gd \
    && docker-php-ext-install pdo pdo_mysql mysqli

RUN docker-php-ext-install opcache


# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

RUN echo 'pm.max_children = 20' >> /usr/local/etc/php-fpm.d/zz-docker.conf && \
    echo 'pm.max_requests = 1000' >> /usr/local/etc/php-fpm.d/zz-docker.conf

RUN echo 'pm.max_children = 20' >> /usr/local/etc/php-fpm.d/www.conf && \
    echo 'pm.max_requests = 1000' >> /usr/local/etc/php-fpm.d/www.conf


# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
WORKDIR /var/www


CMD ["php-fpm"]
EXPOSE 9000
