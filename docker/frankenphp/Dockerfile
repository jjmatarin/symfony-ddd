FROM dunglas/frankenphp:latest

# Instala herramientas necesarias y Composer
RUN apt-get update && apt-get install -y --no-install-recommends \
	acl \
	file \
	gettext \
	supervisor \
	git \
	&& rm -rf /var/lib/apt/lists/*

RUN set -eux; \
	install-php-extensions \
		@composer \
		apcu \
		intl \
		opcache \
		zip \
        gd \
        mbstring \
	;

WORKDIR /app
