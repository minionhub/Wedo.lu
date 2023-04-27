FROM ajoergensen/nginx-php-fpm:7.3

RUN apt-get update && apt-get install -y \
    curl \
    git \
    php-mbstring \
    unzip \
    mc

RUN mkdir /home/app

RUN chown -R app:app /home/app

RUN cd ~ && \
    curl -sS https://getcomposer.org/installer -o composer-setup.php && \
    php composer-setup.php --install-dir=/usr/local/bin --filename=composer && \
    composer self-update

RUN ln -s /var/www/artisan /usr/local/bin

WORKDIR /var/www/public
