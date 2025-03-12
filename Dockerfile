FROM php:8.2-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    zip \
    unzip \
    git

# Install PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd mysqli pdo pdo_mysql

# Set working directory
WORKDIR /var/www/html

# Copy application files
COPY . /var/www/html/

# Create uploads directory and set permissions
RUN mkdir -p /var/www/html/uploads \
    && chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html \
    && chmod -R 777 /var/www/html/uploads

# Configure PHP to use environment variables
RUN echo "env[DB_HOST] = \$DB_HOST" >> /usr/local/etc/php-fpm.d/www.conf \
    && echo "env[DB_DATABASE] = \$DB_DATABASE" >> /usr/local/etc/php-fpm.d/www.conf \
    && echo "env[DB_USER] = \$DB_USER" >> /usr/local/etc/php-fpm.d/www.conf \
    && echo "env[DB_PASSWORD] = \$DB_PASSWORD" >> /usr/local/etc/php-fpm.d/www.conf \
    && echo "env[TZ] = \$TZ" >> /usr/local/etc/php-fpm.d/www.conf

EXPOSE 9000

CMD ["php-fpm"] 