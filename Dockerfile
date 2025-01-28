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

# Copy application files to the Apache server directory
COPY . /var/www/html

# Set permissions for the web root
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Copy the MySQL initialization script
COPY init.sql /docker-entrypoint-initdb.d/

# Expose port 8080 for Cloud Run
EXPOSE 8080

# Start MySQL and Apache
CMD service mysql start && apache2-foreground
