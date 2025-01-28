# Use official PHP image with Apache
FROM php:7.4-apache

# Install MySQL client
RUN apt-get update && apt-get install -y mysql-client

# Enable apache mod_rewrite
RUN a2enmod rewrite

# Copy application files to Apache server directory
COPY . /var/www/html/

# Set permissions for files
RUN chown -R www-data:www-data /var/www/html/

# Expose port 80
EXPOSE 80
