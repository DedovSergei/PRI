FROM php:8.2-apache-bullseye-slim

# Install only the dev libs you need, no extra recommends
RUN apt-get update \
 && apt-get install -y --no-install-recommends \
      libxslt-dev \
      libxml2-dev \
 && docker-php-ext-install mysqli pdo_mysql xsl \
 && rm -rf /var/lib/apt/lists/*

# enable rewrite, etc.
RUN a2enmod rewrite

WORKDIR /var/www/html
