FROM php:8.2-apache

# Remove all MPMs first
RUN a2dismod mpm_event mpm_worker mpm_prefork || true

# Enable only prefork
RUN a2enmod mpm_prefork

# Enable rewrite
RUN a2enmod rewrite

# Install mysqli
RUN docker-php-ext-install mysqli

# Copy files
COPY . /var/www/html/

# Permissions
RUN chown -R www-data:www-data /var/www/html

# Apache fix
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

EXPOSE 80
