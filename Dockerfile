# Use the official PHP image with Apache
FROM php:8.0-apache

# Install required dependencies
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    curl \
    && rm -rf /var/lib/apt/lists/*

# Install necessary PHP extensions
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Download and configure Cloud SQL Proxy
RUN curl -sSL https://dl.google.com/cloudsql/cloud_sql_proxy.linux.amd64 -o /cloud_sql_proxy \
    && chmod +x /cloud_sql_proxy

# Set the port for Cloud Run
ENV PORT 8080
EXPOSE 8080

# Enable Apache mod_rewrite and configure virtual hosts
RUN a2enmod rewrite
COPY . /var/www/html/

# Configure Apache to listen on the PORT environment variable
RUN sed -i 's/80/${PORT}/g' /etc/apache2/sites-available/000-default.conf \
    && sed -i 's/80/${PORT}/g' /etc/apache2/ports.conf

# Set default value for CLOUD_SQL_CONNECTION_NAME
ENV CLOUD_SQL_CONNECTION_NAME "gcp-learning-2008:us-central1:ashwani"

# Start Cloud SQL Proxy and Apache in the background correctly
CMD /cloud_sql_proxy -dir=/cloudsql -instances=$CLOUD_SQL_CONNECTION_NAME & \
    apache2-foreground
