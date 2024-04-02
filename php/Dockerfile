FROM php:8.2-apache

# Installation des dépendances PHP nécessaires
RUN apt-get update \
    && apt-get install -y zlib1g-dev g++ git libicu-dev zip libzip-dev zip \
    && docker-php-ext-install intl opcache pdo pdo_mysql \
    && pecl install apcu \
    && docker-php-ext-enable apcu \
    && docker-php-ext-configure zip \
    && docker-php-ext-install zip \
    && apt-get install -y ca-certificates

# Installation de Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Installation de Symfony CLI
RUN curl -sS https://get.symfony.com/cli/installer | bash \
    && mv /root/.symfony5/bin/symfony /usr/local/bin/symfony

# Définition du répertoire de travail
WORKDIR /var/www

# Copie du code source de l'application
COPY . /var/www

# Exposition du port 8080 (à adapter si nécessaire)
EXPOSE 8080

# Commande par défaut pour démarrer l'application Symfony
CMD ["symfony", "server:start", "--port=8080", "--no-tls"]