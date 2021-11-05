FROM php:7.4-fpm

# Set working directory
WORKDIR /var/www/symfony_4_test

# Install dependencies
RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    locales \
    zip \
    jpegoptim optipng pngquant gifsicle \
    vim \
    unzip \
    git \
    curl

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install extensions
RUN docker-php-ext-install pdo_mysql exif pcntl
RUN docker-php-ext-configure gd
RUN docker-php-ext-install gd

# Add user for laravel application
RUN usermod -u 1000 www-data && groupmod -g 1000 www-data

# Change current user to www
USER 1000:1000

# Expose port 9000 and start php-fpm server
EXPOSE 9000
CMD ["php-fpm"]
