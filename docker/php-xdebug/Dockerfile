FROM php:8.0.30

# USER ROOT
USER 0

# Install system dependencies
RUN apt-get update -y && apt-get install -y \
    build-essential \
    curl \
    git \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Composer
ENV COMPOSER_ALLOW_SUPERUSER=1
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Xdebug
RUN pecl install xdebug && docker-php-ext-enable xdebug

WORKDIR /playlumendice

CMD php -S 0.0.0.0:8000 -t public

EXPOSE 8000