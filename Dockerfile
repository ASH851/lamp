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

# Configure MySQL
RUN service mysql start && mysql -e "CREATE DATABASE registered;" \
    && mysql -e "CREATE USER 'ashwani'@'localhost' IDENTIFIED BY 'ashwani';" \
    && mysql -e "GRANT ALL PRIVILEGES ON registered.* TO 'ashwani'@'localhost';" \
    && mysql -e "FLUSH PRIVILEGES;"

# Copy app files
COPY . /var/www/html

# Expose port 80 for Apache
EXPOSE 80

# Start MySQL and Apache on container start
CMD service mysql start && apache2-foreground
