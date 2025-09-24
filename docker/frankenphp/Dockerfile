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
        pdo_pgsql \
        amqp \
	;

RUN pecl install opentelemetry && docker-php-ext-enable opentelemetry

RUN set -eux; install-php-extensions xdebug;
RUN set -eux; install-php-extensions rdkafka;

RUN groupadd -g 1000 appgroup && useradd -u 1000 -g appgroup -m appuser
RUN chown -R appuser:appgroup /app /data
USER 1000

WORKDIR /app
