# On utilise PHP 8.1 qui est un bon compromis pour un projet de 3 ans
FROM php:8.1-fpm

# Installation des dépendances système nécessaires à Symfony et aux extensions PHP
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libicu-dev \
    libpng-dev \
    libjpeg-dev \
    libzip-dev \
    mariadb-client \
    && docker-php-ext-configure gd --with-jpeg \
    && docker-php-ext-install intl gd zip pdo pdo_mysql

# On récupère Composer depuis l'image officielle
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# On définit le dossier de travail dans le container
WORKDIR /app

# On copie tout le contenu du projet dans le container
COPY . .

# On installe les dépendances PHP (ignore les scripts de post-install pour éviter les erreurs de build)
RUN composer install --no-scripts --no-interaction --optimize-autoloader

# Symfony tourne par défaut sur le port 8000 avec le serveur interne
EXPOSE 8000

# Commande pour lancer le serveur interne de PHP (idéal pour tester rapidement)
CMD ["php", "-S", "0.0.0.0:8000", "-t", "public"]
