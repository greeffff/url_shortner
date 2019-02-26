FROM php:7.2-apache
RUN apt-get update -y && apt-get install -y mariadb-server
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN docker-php-ext-install pdo mbstring
WORKDIR /url
COPY . /url
RUN composer install
ADD 000-default.conf /etc/apache2/sites-available/000-default.conf
CMD php artisan serve —host=0.0.0.0 —port=8080
EXPOSE 8080