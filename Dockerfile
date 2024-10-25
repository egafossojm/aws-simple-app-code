FROM php:8.2-fpm-alpine as base

ARG COMPOSER_AUTH

ENV BUILD_ENV=production

# Set environment variables
ENV COMPOSER_ALLOW_SUPERUSER=1 \
  COMPOSER_HOME=/composer \
  COMPOSER_MAX_PARALLEL_HTTP=24 \
  COMPOSER_AUTH=${COMPOSER_AUTH}

# Install dev packages
RUN apk add --no-cache --virtual .build-deps \
  git \
  $PHPIZE_DEPS

# Install required packages
RUN apk --no-cache update && \
  apk --no-cache upgrade && \
  apk add --no-cache \
  curl \
  nginx \
  nginx-mod-http-cache-purge \
  supervisor \
  git \
  rsync \
  libzip-dev \
  icu-dev \
  gmp-dev \
  imagemagick-dev

RUN pecl install imagick \
  && docker-php-ext-enable imagick

# Install PHP extensions
RUN docker-php-ext-install exif gmp intl mysqli opcache zip

# Copy PHP-FPM configuration
COPY ./docker/php/php-fpm.conf /usr/local/etc/php-fpm.d/zzz-www.conf

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Install Git and clone the server-configs-nginx repository
RUN git clone https://github.com/h5bp/server-configs-nginx.git \
  && cp server-configs-nginx/nginx.conf /etc/nginx/nginx.conf \
  && cp -r server-configs-nginx/h5bp /etc/nginx/h5bp \
  && rm -rf server-configs-nginx \
  && sed -i 's/www-data/nginx/g' /etc/nginx/nginx.conf \
  && sed -i '1s/^/include modules\/\*\.conf;\n/' /etc/nginx/nginx.conf

COPY ./docker/nginx/start.sh /usr/local/bin/start-nginx

# Cleanup APK cache
RUN apk del .build-deps

# Create the Supervisor log directory
RUN mkdir -p /var/log/supervisor

# Copy default configuration
COPY ./docker/nginx/nginx.conf /etc/nginx/conf.d/default.conf
COPY ./docker/supervisor/ /etc/supervisor/
COPY ./entrypoint.sh /entrypoint

WORKDIR /var/www/html

COPY ./bedrock /var/www/html

RUN COMPOSER_AUTH=${COMPOSER_AUTH} composer install --optimize-autoloader

WORKDIR /var/www/html/web/app/themes/${THEME_NAME}

RUN composer install --optimize-autoloader --no-dev

# Install WP-CLI
RUN curl -o /usr/local/bin/wp https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar && \
  chmod +x /usr/local/bin/wp
ARG NODE_VERSION=16
# Multi-stage build: Build static assets
# This allows us to not include Node within the final container
FROM node:${NODE_VERSION} as node_modules_image

ARG THEME_NAME

RUN mkdir -p /app

WORKDIR /app

COPY ./bedrock/web/app/themes/${THEME_NAME} .

RUN if [ -f "yarn.lock" ]; then \
  yarn install --frozen-lockfile; \
  yarn build; \
  elif [ -f "pnpm-lock.yaml" ]; then \
  corepack enable && corepack prepare pnpm@latest-8 --activate; \
  pnpm install --frozen-lockfile; \
  pnpm run build; \
  elif [ -f "package-lock.json" ]; then \
  npm ci --no-audit; \
  npm run build; \
  else \
  npm install; \
  npm run build; \
  fi;

# From our base container created above, we
# create our final image, adding in static
# assets that we generated above
FROM base

ARG THEME_NAME

# Packages may have added assets to the public directory
# or maybe some custom assets were added manually! Either way, we merge
# in the assets we generated above rather than overwrite them
COPY --from=node_modules_image /app/public /var/www/html/public-npm
RUN rsync -ar /var/www/html/public-npm/ /var/www/html/web/app/themes/${THEME_NAME}/public/ \
  && rm -rf /var/www/html/public-npm

# Fix permissions
RUN find /var/www/html -type f -exec chown www-data:www-data {} \; -exec chmod 0664 {} \; -o \
  -type d -exec chown www-data:www-data {} \; -exec chmod 0775 {} \;

EXPOSE 8080

ENTRYPOINT ["/entrypoint"]

