FROM php:7.0-cli

WORKDIR /var/www/html

RUN apt-get update && apt-get install -y \
        apt-transport-https \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libmcrypt-dev \
        libpng12-dev \
        libicu-dev \
        zlib1g-dev \
        git \
        sudo \
        unzip \
    && docker-php-ext-install -j$(nproc) pdo pdo_mysql iconv mcrypt intl zip \
    && docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ \
    && docker-php-ext-install -j$(nproc) gd \
    && apt-get autoremove -y \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

RUN pecl install xdebug \
    && pecl clear-cache \
    && echo "zend_extension=/usr/local/lib/php/extensions/no-debug-non-zts-20151012/xdebug.so" > /usr/local/etc/php/conf.d/xdebug.ini

RUN echo -e "\nmemory_limit = -1" >> /usr/local/etc/php/conf.d/php.ini
RUN echo -e "\ndate.timezone = Europe/Warsaw" >> /usr/local/etc/php/conf.d/php.ini
RUN echo -e "\nshort_open_tag = off" >> /usr/local/etc/php/conf.d/php.ini
RUN echo "\nxdebug.remote_enable=on" >> /usr/local/etc/php/conf.d/xdebug.ini
RUN echo "\nxdebug.remote_autostart=off" >> /usr/local/etc/php/conf.d/xdebug.ini

RUN echo "export TERM=xterm" >> ~/.bashrc

RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php composer-setup.php \
    && php -r "unlink('composer-setup.php');" \
    && mv composer.phar /usr/local/bin/composer

COPY entrypoint.sh /usr/local/bin/entrypoint.sh

CMD ["/bin/bash", "/usr/local/bin/entrypoint.sh"]
