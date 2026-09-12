FROM node:22-alpine AS frontend
WORKDIR /app
COPY package.json package-lock.json* ./
RUN npm install
COPY resources ./resources
COPY public ./public
COPY vite.config.js .
RUN npm run build

FROM composer:2 AS vendor
WORKDIR /app
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader --no-scripts

FROM php:8.3-cli
WORKDIR /var/www/html

RUN apt-get update \
    && apt-get install -y --no-install-recommends libpq-dev libicu-dev libonig-dev \
    && docker-php-ext-install pdo_pgsql mbstring intl bcmath \
    && rm -rf /var/lib/apt/lists/*

COPY --from=vendor /app/vendor ./vendor
COPY --from=frontend /app/public/build ./public/build
COPY . .

RUN php artisan package:discover --ansi

RUN mkdir -p storage/framework/cache storage/framework/sessions storage/framework/views bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

ENV DISCORD_BOT_AUTOSTART=false
ENV APP_ENV=production
ENV APP_DEBUG=false

CMD sh -c "php artisan optimize:clear && php artisan migrate --force && php artisan optimize && php artisan serve --host=0.0.0.0 --port=${PORT:-8080}"
