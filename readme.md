## Application de Gestion des Titres d'Accès Temporaires au Port Autonome de Cotonou

Projet de stage au Port Autonome de Cotonou, Bénin

### Problématique 
Les titres d'accès sont les "badges" qu'utilisent les usagers du Port Autonome de Cotonou pour qu'il y ait un contrôle de son accès. Une application Desktop existe et sert à la gestion de ces titres d'accès et accessoirement (également) à la gestion du parc automobile du Port. 

Cependant l'accès au données (comme la recherche d'un profil existant par exemple) à partir de cette application est de plus en plus lente (jusqu'à 5 minutes d'attente suivi parfois de crash !).  
Les contraintes d'intégrité des données ne sont pas respectées et plusieurs (mêmes) tâches élémentaires sont à réaliser plusieurs fois dans le cycle de vie d'application (comme l'enregistrement des informations d'un usager) par le personnel utilisateur du système au Port de Cotonou.  
Les mises à jour de l'application se font en installation "dure" sur chaque poste, et d'autres problèmes encore.  

Cette application web vient moderniser l'existant et offrir une plateforme qui tient mieux compte des exigences existantes.

AGTAT's [Classes Diagram](https://drive.google.com/file/d/1h9uP7Y92HlJ8ArP-ZNLSNp2p9Wyoshvk/view?usp=sharing)

\
__Environnement technique__ 
* PHP
* Laravel
* MySql
* jQuery
* Materialize

__Requirements__
- [Composer](https://getcomposer.org/download/)
- [Docker](https://docs.docker.com/get-docker/)

__Getting started__

Install dependencies
```bash
composer install
```

Environment variables available
```bash
cp .env.example .env
```

Run docker compose stack
```bash
docker-compose up -d
```

Generate application key and migrate data
```bash
docker-compose exec app key:generate
docker-compose exec app php artisan migrate:refresh --seed
```

__TODO__\
Write feature tests