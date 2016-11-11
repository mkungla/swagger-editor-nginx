# Use official Alpine image
FROM alpine:edge
MAINTAINER Marko Kungla <marko@okramlabs.com>

# Build arguments
ARG SEN_SWAGGER_EDITOR_VERSION="v2.10.4"
ARG SEN_SWAGGER_VERSION="2.10.4"

# Image labels
LABEL com.okramlabs.swagger-editor-nginx.version=$SEN_SWAGGER_EDITOR_VERSION
LABEL com.example.release-date="11.11.2016"

ENV PERSISTENT_DEPS \
    # Add system packages
    nginx \
    bash \
    su-exec \

    # Add PHP packages
    php7 \
    php7-fpm \
    php7-opcache \
    php7-session \
    php7-dom \
    php7-xml \
    php7-xmlreader \
    php7-ctype \
    php7-json \
    php7-posix \
    php7-curl \
    php7-sockets \
    php7-zlib \
    php7-mcrypt \
    php7-sqlite3 \
    php7-bz2 \
    php7-openssl \
    php7-posix \
    php7-zip \
    php7-calendar \
    php7-mbstring \
    php7-exif \
    php7-xsl \
    php7-bcmath

ENV BUILD_DEPS \
        wget \
        unzip \
        ca-certificates \
        dpkg \
        gnupg \
        openssl


RUN set -xe \
     # Add presistent dependecies
    && apk add --update --no-cache $PERSISTENT_DEPS \

    # add build dependecies
    && apk add --no-cache --virtual .build-deps $BUILD_DEPS \

    # Add docke user
    && adduser -D -u 1000 docker \

    # Get Swagger Editor
    && mkdir -p /usr/src \
    && cd /usr/src \
    && wget https://github.com/swagger-api/swagger-editor/releases/download/v2.10.4/swagger-editor.zip \
    && unzip swagger-editor.zip \
    && rm swagger-editor.zip \
    && mkdir -p /var/www/localhost/htdocs \
    && mv /usr/src/swagger-editor/* /var/www/localhost/htdocs \

    # Clean UP
    && rm -rf \
       /usr/include/php7 \
       /usr/lib/php7/build \
       /usr/lib/php7/modules/*.a \
       /var/cache/apk/* \
       /usr/share/man \
       /tmp/* \

    # Remove build dependencies
    && apk del .build-deps

# Over write some files
ADD rootfs /

RUN set -xe \
    && chmod +x /entrypoint.sh \

    # Create symlinks PHP -> PHP7
    && ln -sf /usr/bin/php7 /usr/bin/php \
    && ln -sf /usr/sbin/php-fpm7 /usr/bin/php-fpm \

    # Configure PHP
    && sed -i \
        -e "s/^expose_php.*/expose_php = Off/" \
        -e "s/^;date.timezone.*/date.timezone = Europe\/Amsterdam/" \
        -e "s/^memory_limit.*/memory_limit = -1/" \
        -e "s/^max_execution_time.*/max_execution_time = 600/" \
        -e "s/^post_max_size.*/post_max_size = 512M/" \
        -e "s/^upload_max_filesize.*/upload_max_filesize = 512M/" \
    /etc/php7/php.ini \

    # nginx config
    && mkdir -p /run/nginx \

    # Fix permissions
    && chmod u+s /sbin/su-exec \
    && chown -R docker:docker /var/www/localhost/htdocs


# User who we run as
USER docker

ENTRYPOINT ["/entrypoint.sh"]

WORKDIR /var/www/localhost/htdocs

EXPOSE 80