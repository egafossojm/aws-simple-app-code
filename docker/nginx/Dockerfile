# Use the latest Nginx Alpine base image
FROM php:8.2-fpm-alpine

ARG BUILD_ENV

# Install Git and clone the server-configs-nginx repository
RUN apk --update add --no-cache --virtual .build-deps git \
    && apk add --no-cache nginx-mod-http-cache-purge \
    && git clone https://github.com/h5bp/server-configs-nginx.git \
    && cp server-configs-nginx/nginx.conf /etc/nginx/nginx.conf \
    && cp -r server-configs-nginx/h5bp /etc/nginx/h5bp \
    && rm -rf server-configs-nginx \
    && sed -i 's/www-data/nginx/g' /etc/nginx/nginx.conf \
    && sed -i '1s/^/include modules\/\*\.conf;\n/' /etc/nginx/nginx.conf

# Copy your custom Nginx configuration for WordPress
COPY nginx.conf /etc/nginx/conf.d/default.conf

RUN if [ "$BUILD_ENV" = "development" ]; then \
        sed -i 's/fastcgi_pass 127.0.0.1:9000/fastcgi_pass php:9000/g' /etc/nginx/conf.d/default.conf; \
    fi


EXPOSE 80

CMD ["nginx", "-g", "daemon off;"]