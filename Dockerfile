# Use an official PHP image with Apache
FROM php:8.1-apache

# Install required PHP extensions and tools
RUN apt-get update && apt-get install -y \
    mariadb-client \
    libpng-dev libjpeg-dev libfreetype6-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo_mysql mysqli gd

# Copy application files to the container
WORKDIR /var/www/html
COPY . /var/www/html

# Ensure Apache serves on the Cloud Run expected port
ENV PORT=8080
RUN sed -i "s/Listen 80/Listen ${PORT}/" /etc/apache2/ports.conf

# Expose the Cloud Run port
EXPOSE 8080

# Start Apache
CMD ["apache2-foreground"]
