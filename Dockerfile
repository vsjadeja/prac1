FROM alpine:3.10

LABEL Maintainer="Virendra Jadeja <virendrajadeja84@gmail.com>" \
    Description="Lightweight container for laravel based on Alpine Linux."

# Install packages
RUN apk --no-cache add php7 php7-fpm php7-mysqli php7-tokenizer php7-json php7-openssl php7-curl \
    php7-zlib php7-xml php7-dom php7-xmlreader php7-ctype php7-session \
    php7-mbstring php7-gd php7-fileinfo php7-pdo_mysql php7-redis php7-sqlite3 php7-pdo_sqlite php7-opcache nginx supervisor curl

# Configure nginx
COPY ./docker-conf/nginx.conf /etc/nginx/nginx.conf
# Remove default server definition
RUN rm /etc/nginx/conf.d/default.conf

# Configure PHP-FPM
COPY ./docker-conf/fpm-pool.conf /etc/php7/php-fpm.d/www.conf
COPY ./docker-conf/php.ini /etc/php7/conf.d/custom.ini

# Configure supervisord
COPY ./docker-conf/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Make sure files/folders needed by the processes are accessable when they run under the nobody user
RUN chown -R nobody.nobody /run && \
    chown -R nobody.nobody /var/lib/nginx && \
    chown -R nobody.nobody /var/tmp/nginx && \
    chown -R nobody.nobody /var/log/nginx

# Setup document root
RUN mkdir -p /var/www/html

# Switch to use a non-root user from here on
USER nobody

# Add application
WORKDIR /var/www/html
COPY --chown=nobody ./ /var/www/html/

# Expose the port nginx is reachable on
EXPOSE 8080

# Let supervisord start nginx & php-fpm
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]

# Configure a healthcheck to validate that everything is up&running
HEALTHCHECK --interval=15s --timeout=3s CMD curl --silent --fail http://127.0.0.1:8080/fpm-ping
