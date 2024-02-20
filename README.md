# soigneMoi

## Prérequis
- Docker Compose installé

## Instructions
1. Se placer dans le répertoire et démarrer les conteneurs Docker :
    ```bash
    docker-compose up -d
    ```

2. Accéder au conteneur PHP :
    ```bash
    docker-compose exec php /bin/bash
    ```

3. Installer les dépendances PHP avec Composer :
    ```bash
    composer install
    symfony console importmap:install
    ```

4. Configurer le fichier `.env` avec les valeurs nécessaires, y compris les secrets.
    ```bash
    openssl genpkey -out config/jwt/private.pem -aes256 -algorithm rsa -pkeyopt rsa_keygen_bits:4096
    openssl pkey -in config/jwt/private.pem -out config/jwt/public.pem -pubout
    ```
5. Exécuter les migrations de la base de données :
    ```bash
    symfony console doctrine:migrations:migrate
    ```

6. Charger les fixtures de la base de données :
    ```bash
    symfony console doctrine:fixtures:load
    ```
7. Se rendre sur localhost:8080/ pour la WebApp et localhost:8899/ pour la BDD

