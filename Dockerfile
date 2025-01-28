# Use the official PHP image with Apache
FROM php:8.0-apache

# Install MySQL client and Cloud SQL connector
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    default-mysql-client

# Install necessary PHP extensions (mysqli and pdo_mysql)
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Install Cloud SQL connector
RUN apt-get install -y curl
RUN curl -sSL https://dl.google.com/cloudsql/cloud_sql_proxy.linux.amd64 -o /cloud_sql_proxy
RUN chmod +x /cloud_sql_proxy

# Expose port 8080 for Cloud Run
ENV PORT 8080
EXPOSE 8080

# Enable Apache mod_rewrite and copy the app
RUN a2enmod rewrite
COPY . /var/www/html/

# Command to run the Cloud SQL Proxy and Apache
CMD /cloud_sql_proxy -dir=/cloudsql -project=$GOOGLE_CLOUD_PROJECT -instances=$CLOUD_SQL_CONNECTION_NAME & apache2-foreground
