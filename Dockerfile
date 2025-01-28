# Use official PHP image with Apache as the base image
FROM php:8.0-apache

# Install necessary dependencies
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    default-mysql-client \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd

# Enable mod_rewrite for Apache (commonly needed for LAMP stack)
RUN a2enmod rewrite

# Copy application files to the container
COPY . /var/www/html/

# Set environment variables for Cloud SQL connection (adjust accordingly)
ENV CLOUD_SQL_CONNECTION_NAME="your-project-id:your-region:your-db-instance"
ENV DB_HOST="/cloudsql/${CLOUD_SQL_CONNECTION_NAME}"
ENV DB_USERNAME="your-db-username"
ENV DB_PASSWORD="your-db-password"
ENV DB_NAME="lamp_db"

# Install Cloud SQL Proxy (optional if needed for connecting to Cloud SQL)
RUN apt-get install -y curl \
    && curl -sSL https://dl.google.com/cloudsql/cloud_sql_proxy.linux.amd64 -o /cloud_sql_proxy \
    && chmod +x /cloud_sql_proxy \
    && mv /cloud_sql_proxy /usr/local/bin/

# Set entrypoint to run Cloud SQL Proxy (if you're using it)
ENTRYPOINT ["/usr/local/bin/cloud_sql_proxy", "-dir=/cloudsql"]

# Expose the default Apache port
EXPOSE 80

# Define the command to run your app
CMD ["apache2-foreground"]
