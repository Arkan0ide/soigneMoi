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
    mkdir -p config/jwt && \
    openssl genpkey -out config/jwt/private.pem -aes256 -algorithm rsa -pkeyopt rsa_keygen_bits:4096 && \
    openssl pkey -in config/jwt/private.pem -out config/jwt/public.pem -pubout
    ```
    
Un problème récurrent de droit est présent à la génération des clés.
Dans le docker, l'utilisateur est www-data qui fait partie du group other. Pour lire ces fichiers, cela demande les droits 7 sur le group other.
Ce n'est pas recommmandé mais sans cela l'accès à l'api n'est pas possible. 

5. Exécuter les migrations de la base de données :
   ```bash
    symfony console doctrine:migrations:migrate
    ```

6. Charger les fixtures de la base de données :
    ```bash
    symfony console doctrine:fixtures:load
    ```
7. Se rendre sur localhost:8080/ pour la WebApp et localhost:8899/ pour la BDD

8. En cas d'erreur lié au certificat ssl (mon_conteneur est obtenu via la commande docker ps) :
    ```bash
   docker cp /etc/ssl/certs/ca-certificates.crt mon_conteneur:/etc/ssl/certs/ca-certificates.crt
    ```
