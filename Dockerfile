# Step 1: Use an official PHP image with Apache
FROM php:8.1-apache

# Step 2: Install necessary system packages and PHP extensions
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libonig-dev \
    libzip-dev \
    unzip \
    curl \
    mariadb-client \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo_mysql gd zip mbstring

# Step 3: Enable Apache mod_rewrite (useful for frameworks like Laravel, CodeIgniter, etc.)
RUN a2enmod rewrite

# Step 4: Copy application files to the container
WORKDIR /var/www/html
COPY . /var/www/html

# Step 5: Set permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Step 6: Expose the default Apache port
EXPOSE 80

# Step 7: Start Apache in the foreground
CMD ["apache2-foreground"]
