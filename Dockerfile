# Step 1: Use an official PHP image as the base image
FROM php:7.4-apache

# Step 2: Update the package list and install dependencies
RUN apt-get update && apt-get install -y \
    libmysqlclient-dev \
    && rm -rf /var/lib/apt/lists/*

# Step 3: Set the environment variable for the port Cloud Run uses
ENV APACHE_LISTEN 8080

# Step 4: Expose port 8080, which is required for Cloud Run
EXPOSE 8080

# Step 5: Enable mod_rewrite for Apache (if needed for your app)
RUN a2enmod rewrite

# Step 6: Copy the application code into the container
COPY . /var/www/html/

# Step 7: Set the correct permissions for the application files
RUN chown -R www-data:www-data /var/www/html/

# Step 8: Set environment variables for database connection (can be overridden at runtime)
# This DB_HOST value will be set dynamically by Cloud Run
ENV DB_HOST /cloudsql/${DB_INSTANCE_CONNECTION_NAME}
ENV DB_USER=${DB_USER}
ENV DB_PASSWORD=${DB_PASSWORD}
ENV DB_NAME=${DB_NAME}

# Step 9: Configure Apache to listen on the correct port
RUN sed -i "s/Listen 80/Listen 8080/" /etc/apache2/ports.conf
RUN sed -i "s/<VirtualHost *:80>/<VirtualHost *:8080>/" /etc/apache2/sites-available/000-default.conf

# Step 10: Start Apache in the foreground
CMD ["apache2-foreground"]
