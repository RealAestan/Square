# Test Square

L'application utilise symfony 6.1 et PHP 8.1.
Le code source utilise l'architecture hexagonale avec l'arboresence suivante :
- Application
- Domain
- Infrastructure

## Pre-requis

- PHP 8.1
- composer 2.4
- docker-compose pour la BDD postgres (sinon configurer la variable DATABASE_URL dans .env.local)

## Installation

Pour installer le projet :

- Configurer les variables d'environnement `LA_BONNE_BOITE_CLIENT_ID` et `LA_BONNE_BOITE_CLIENT_SECRET` dans un fichier .env.local à la racine du projet
- Lancer les commandes suivantes :
  - `docker-compose up -d`
  - `composer install`
  - `symfony server:start -d`
  - `bin/console doctrine:migrations:migrate --no-interaction`

## Token API

Pour générer un token API lancer la commande suivante :

`bin/console app:api-key:generate -v`

Le token généré est affiché dans l'output de la commande.

Les tokens ont un quota de 10 requêtes.

## Endpoint API

L'endpoint est `/api/companies`.

Il prend en entrée les paramètres suivant :
- `city` le nom de la ville, obligatoire
- `zip_code` le code postal de la ville, obligatoire
- `job_title` le tite du poste recherché, obligatoire
- `size` le nombre d'element par page, optionnel 30 par défaut
- `page` le numéro de la page souhaité, optionnel 1 par défaut

Pour s'authentifier il faut utiliser la clé API dans le header `X-Auth-Token`

Le quota de requêtes restant est affiché dans la réponse dans le header `X-Quota-Left`

Exemple de requête Curl :

```
curl --location --request GET 'https://127.0.0.1:8000/api/companies?city=Mâcon&zip_code=71000&job_title=Developpeur' \
--header 'x-auth-token: 872b8df82e2fe5674ebd7802993d264f04dc8c55e9f60250c05498b1e785dfbd'
```

# Annexes

- [La bonne boîte](https://pole-emploi.io/data/api/bonne-boite?tabgroup-api=documentation&doc-section=api-doc-section-rechercher-des-entreprises-susceptibles-de-recruter-dans-les-6-prochains-mois)
- [Geo API](https://geo.api.gouv.fr/decoupage-administratif/communes)
