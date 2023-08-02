FROM php:8.2-fpm

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


# Remove development files and directories
RUN rm -rf .git

# Install MySQL extension for PHP
RUN docker-php-ext-install pdo pdo_mysql

# Expose port 8000 (optional, you can use a reverse proxy like Nginx instead)
EXPOSE 8000

# Start the Symfony server
CMD ["sh", "-c", "php -S 0.0.0.0:8000 -t public/"]
