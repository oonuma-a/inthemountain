# PHPとNode.js 14系のインストール
FROM php:8.1-fpm

# システムパッケージのインストール（必要なライブラリやNode.jsなど）
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    zip \
    git \
    curl \
    libicu-dev \
    libxml2-dev \
    libssl-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd intl xml opcache pdo pdo_mysql bcmath \
    && pecl install xdebug \
    && docker-php-ext-enable xdebug

# Composerのインストール
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Node.js 14系のインストール
RUN curl -fsSL https://deb.nodesource.com/setup_14.x | bash - \
    && apt-get install -y nodejs \
    && apt-get install -y npm

# 作業ディレクトリの設定
WORKDIR /var/www/html

# PHPの依存関係をインストール
COPY composer.json composer.lock ./
RUN composer install --no-autoloader --no-scripts

# 必要に応じてNPMのインストール
COPY package.json package-lock.json ./
RUN npm install
