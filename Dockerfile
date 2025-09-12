FROM php:8.2-fpm-alpine

# Install system dependencies
RUN apk add --no-cache \
    git \
    mysql-client

# Install PHP extensions
RUN docker-php-ext-install \
    pdo_mysql

# Set working directory inside the container
WORKDIR /var/www/html

# Expose port 8000 for Laravel development server
EXPOSE 8000
