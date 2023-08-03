FROM php:8.2

WORKDIR /app

RUN apt-get update && apt-get install -y \
    curl \
    default-mysql-client


# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copy project files
COPY . /app

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Add /usr/local/bin to the PATH
ENV PATH="${PATH}:/usr/local/bin"

# Install MySQL extension for PHP
RUN docker-php-ext-install pdo pdo_mysql

# Expose port 8000
EXPOSE 8000

# Install dependencies
RUN composer install

# Start the Symfony server
CMD ["sh", "-c", "php bin/console cache:clear && php -S 0.0.0.0:8000 -t public/"]
