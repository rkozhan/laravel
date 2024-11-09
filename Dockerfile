# Use official PHP image with Apache
FROM php:8.2-apache

# Set working directory
WORKDIR /var/www/html

# Install dependencies
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    zip \
    curl

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# Install Composer globally
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy application files
COPY . /var/www/html

# Set permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Expose port 80
EXPOSE 80

# Start Apache server
CMD ["apache2-foreground"]
