FROM php:8.2-apache

# Disable conflicting MPMs
RUN a2dismod mpm_event mpm_worker && a2enmod mpm_prefork

# Enable rewrite
RUN a2enmod rewrite

# Install mysqli
RUN docker-php-ext-install mysqli

# Copy project
COPY . /var/www/html/

# Permissions
RUN chown -R www-data:www-data /var/www/html

EXPOSE 80
