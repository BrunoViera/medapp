FROM ubuntu:18.04

RUN ln -snf /usr/share/zoneinfo/UTC /etc/localtime && echo "UTC" > /etc/timezone
RUN apt-get update && apt-get upgrade -y && apt-get install -y apt-utils vim curl git unzip gnupg
RUN apt-get update && apt-get install -y php-cli php-fpm php-mysql php-xml php-curl php-zip php-mbstring php-xdebug php-imagick php-gd

ADD etc/php/7.2/fpm/conf.d/ /etc/php/7.2/fpm/conf.d/
ADD etc/php/7.2/cli/conf.d/ /etc/php/7.2/cli/conf.d/
ADD etc/php/7.2/fpm/pool.d/www.conf /etc/php/7.2/fpm/pool.d/

RUN mkdir /run/php

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin/ --filename=composer

WORKDIR /home/app

CMD ["php-fpm7.2", "-F"]
