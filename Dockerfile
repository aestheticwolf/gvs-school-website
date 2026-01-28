FROM php:8.2-fpm

# Install nginx
RUN apt-get update && apt-get install -y nginx

# Install mysqli
RUN docker-php-ext-install mysqli

# Copy project
COPY . /var/www/html/

# Nginx config
RUN rm /etc/nginx/sites-enabled/default

RUN echo 'server { \
    listen 80; \
    root /var/www/html; \
    index index.php index.html; \
    location / { \
        try_files $uri $uri/ /index.php?$query_string; \
    } \
    location ~ \.php$ { \
        include fastcgi_params; \
        fastcgi_pass 127.0.0.1:9000; \
        fastcgi_index index.php; \
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name; \
    } \
}' > /etc/nginx/sites-enabled/default

# Permissions
RUN chown -R www-data:www-data /var/www/html

EXPOSE 80

CMD service nginx start && php-fpm
