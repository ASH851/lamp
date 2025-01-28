# Base Image
FROM php:8.1-apache

# Install required packages and PHP extensions
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    && docker-php-ext-install mysqli gd \
    && docker-php-ext-enable mysqli

# Copy application files to the Apache server directory
COPY . /var/www/html/

# Set permissions for the web root
RUN chown -R www-data:www-data /var/www/html/ \
    && chmod -R 755 /var/www/html/

# Configure Apache
RUN sed -i 's/Listen 80/Listen ${PORT}/g' /etc/apache2/ports.conf && \
    sed -i 's/:80/:${PORT}/g' /etc/apache2/sites-available/000-default.conf

# Enable Apache modules
RUN a2enmod rewrite

# Set environment variables
ENV PORT 8080
ENV APACHE_RUN_USER www-data
ENV APACHE_RUN_GROUP www-data
ENV APACHE_LOG_DIR /var/log/apache2
ENV APACHE_RUN_DIR /var/run/apache2
ENV APACHE_PID_FILE /var/run/apache2/apache2.pid

# Create required directories
RUN mkdir -p $APACHE_RUN_DIR $APACHE_LOG_DIR

# Expose port
EXPOSE 8080

# Start Apache
CMD ["apache2-foreground"]
