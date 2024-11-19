# Use an official PHP image with Apache for PHP 8.3
FROM php:8.3-apache

# Install dependencies
RUN apt-get update && apt-get install -y \
    libzip-dev \
    unzip \
    && docker-php-ext-install zip pdo pdo_mysql

# Enable Apache rewrite module for .htaccess (needed for Laravel)
RUN a2enmod rewrite

# Set working directory inside the container
WORKDIR /var/www/html

# Copy the entire project directory from the build context into the container
COPY . /var/www/html

# Set the proper ownership for Laravel directories
RUN chown -R www-data:www-data /var/www/html/public /var/www/html/storage /var/www/html/bootstrap/cache

# Ensure Laravel storage and bootstrap/cache are writable by Apache
RUN chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache && \
    chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Install Laravel dependencies
RUN composer install --no-dev --optimize-autoloader --ignore-platform-reqs

# Configure Apache to serve Laravel's public directory
RUN echo "DocumentRoot /var/www/html/public" > /etc/apache2/sites-available/000-default.conf && \
    echo "<Directory /var/www/html/public>\n\
    AllowOverride All\n\
    Require all granted\n\
    </Directory>" >> /etc/apache2/sites-available/000-default.conf && \
    a2enmod rewrite


# Expose port 80 for Apache
EXPOSE 80

# Start Apache in the foreground
CMD ["apache2-foreground"]
