# Use official PHP 8.2 with Apache (lightweight & production-ready)
FROM php:8.2-apache

# Enable required Apache modules
RUN a2enmod rewrite headers

# Install PHP extensions (if needed later — keep minimal for now)
# RUN docker-php-ext-install mysqli pdo pdo_mysql

# Copy ONLY the 'public' folder to web root
COPY public/ /var/www/html/

# Set proper ownership
RUN chown -R www-data:www-data /var/www/html && \
    chmod -R 755 /var/www/html

# Expose port 80 (Render handles proxying)
EXPOSE 80

# Optional: override default index if needed
# CMD ["apache2-foreground"]