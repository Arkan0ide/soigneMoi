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
    ```

4. Configurer le fichier `.env` avec les valeurs nécessaires, y compris les secrets et la clé de génération.

5. Exécuter les migrations de la base de données :
    ```bash
    symfony console doctrine:migrations:migrate
    ```

6. Charger les fixtures de la base de données :
    ```bash
    symfony console doctrine:fixtures:load
    ```
