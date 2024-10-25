FROM node:20

ARG THEME_NAME

WORKDIR /app/${THEME_NAME}

COPY ./entrypoint.sh /entrypoint

ENTRYPOINT ["/entrypoint"]
