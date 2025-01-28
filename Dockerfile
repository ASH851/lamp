# Example Dockerfile for a PHP LAMP app
FROM php:8.0-apache

# Install dependencies
RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli

# Set Apache to listen on port 8080
ENV APACHE_RUN_PORT=8080
EXPOSE 8080

# Copy application files
COPY . /var/www/html/

# Start the Apache server
CMD ["apache2-foreground"]
