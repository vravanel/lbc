# Installation

Clonez ce projet.

## Lancer l'application en mode Watch

Pour démarrer l'application en mode watch :

```bash
HTTP_PORT=8000 docker compose up --pull always -d --wait
```

### Pour voir les logs :

```bash
docker compose logs -f
```

### Accéder à l'application : https://localhost/

## Arrêter les conteneurs Docker
Pour arrêter les conteneurs Docker :
```bash
docker compose down --remove-orphans
```
## Base de données

Les migrations s'éxécutent au lancement du docker. Pour éxécuter d'autres migrations en dev : 
```bash
docker compose exec php php bin/console d:m:m
```

Concernant les fixtures, elles ne s'éxécutent pas au démarrage du container : 
```bash
docker compose exec php php bin/console d:f:l
```

Accédez à phpMyAdmin via : http://localhost:8080/

## Accéder aux conteneurs

Accéder au Bash dans le conteneur PHP
```bash
docker compose exec php bash
```
Accéder à l'Ash dans le conteneur Node
```bash
docker compose exec node ash
```


## Docs

1. [Options available](docs/options.md)
2. [Using Symfony Docker with an existing project](docs/existing-project.md)
3. [Support for extra services](docs/extra-services.md)
4. [Deploying in production](docs/production.md)
5. [Debugging with Xdebug](docs/xdebug.md)
6. [TLS Certificates](docs/tls.md)
7. [Using MySQL instead of PostgreSQL](docs/mysql.md)
8. [Using Alpine Linux instead of Debian](docs/alpine.md)
9. [Using a Makefile](docs/makefile.md)
10. [Updating the template](docs/updating.md)
11. [Troubleshooting](docs/troubleshooting.md)

## License

Symfony Docker is available under the MIT License.

## Credits

Created by [Kévin Dunglas](https://dunglas.dev), co-maintained by [Maxime Helias](https://twitter.com/maxhelias) and sponsored by [Les-Tilleuls.coop](https://les-tilleuls.coop).
