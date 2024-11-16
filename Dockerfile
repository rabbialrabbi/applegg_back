FROM php:8.3-apache

# Install necessary packages
RUN apt-get update && \
    apt-get install \
    libzip-dev \
    wget \
    git \
    unzip \
    vim \
    -y --no-install-recommends

# Setup virtual host into container
RUN wget -O /etc/apache2/sites-available/000-default.conf https://gist.githubusercontent.com/rabbialrabbi/ba3df1530fb8c16a6a6228e40542ef27/raw/08e3ffdc30464c037d54bea414eacfad23ebb153/000-default.conf

# Enable rewrite mode
RUN a2enmod rewrite

# Install PHP Extensions
RUN docker-php-ext-install zip pdo_mysql

# Get composer installable
RUN wget -O ./install-composer.sh https://gist.githubusercontent.com/rabbialrabbi/d8b304873e22d0df401b0abbee370827/raw/094a968c61fad2cc4c80bcfd3f79e5d393970fff/install-composer.sh

# Setup php.ini
RUN wget -O /usr/local/etc/php/php.ini https://gist.githubusercontent.com/rabbialrabbi/5f81806aeba8c88f13f19fc0dc3f1ee0/raw/e0f8b297b25ebe24a02f85f8afe88c203ed758bd/php.ini

# Cleanup packages and install composer
RUN apt-get purge -y g++ \
    && apt-get autoremove -y \
    && rm -r /var/lib/apt/lists/* \
    && rm -rf /tmp/* \
    && sh ./install-composer.sh \
    && rm ./install-composer.sh

# Change the current working directory
WORKDIR /var/www

# Copy all file
COPY . .

# Install composer
#RUN composer install

# Start Apache in foreground
CMD ["apache2-foreground"]
