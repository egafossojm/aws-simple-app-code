FROM php:8.2-fpm-alpine

# Set environment variables
ENV COMPOSER_ALLOW_SUPERUSER=1 \
  COMPOSER_HOME=/composer \
  COMPOSER_MAX_PARALLEL_HTTP=24

# Install dev packages
RUN apk add --no-cache --virtual .build-deps \
  git \
  linux-headers \
  $PHPIZE_DEPS

# Install required packages
RUN apk --no-cache update && \
  apk --no-cache upgrade && \
  apk add --no-cache \
  curl \
  supervisor \
  git \
  rsync \
  libzip-dev \
  icu-dev \
  imagemagick-dev

# Install Imagick
RUN pecl install imagick \
  && docker-php-ext-enable imagick

# Install xdebug
RUN pecl install xdebug \
  && docker-php-ext-enable xdebug

# Install PHP extensions
RUN docker-php-ext-install exif intl mysqli opcache zip

# Copy PHP-FPM configuration
COPY php-fpm.conf /usr/local/etc/php-fpm.d/zzz-www.conf

# Copy the conf.d directory to /usr/local/etc/php/conf.d
COPY conf.d/* /usr/local/etc/php/conf.d/

# Create the 'nginx' user and group
RUN addgroup -g 1000 nginx && \
  adduser -u 1000 -G nginx -s /bin/sh -D nginx

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Install WP-CLI
RUN curl -o /usr/local/bin/wp https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar && \
  chmod +x /usr/local/bin/wp

# Copy the entrypoint script
COPY entrypoint.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/entrypoint.sh

# Expose PHP-FPM port
EXPOSE 9000

# Set the entrypoint
ENTRYPOINT ["entrypoint.sh"]
