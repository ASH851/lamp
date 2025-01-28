# Base Image
FROM php:8.1-apache

# Install required packages and PHP extensions
RUN apt-get update && apt-get install -y \
    mariadb-server \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    && docker-php-ext-install mysqli gd \
    && docker-php-ext-enable mysqli

# Copy app files to Apache server directory
COPY . /var/www/html

# Expose port 80 for Apache
EXPOSE 80

# Copy MySQL initialization script
COPY init.sql /docker-entrypoint-initdb.d/

# Start both MySQL and Apache when the container starts
CMD service mysql start && apache2-foreground
