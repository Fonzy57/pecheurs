# Création d'une api avec le framework Symfony.

Explication des différentes étapes:

## 1 - Mise en place du projet Symfony

Il suffit d'éxécuter cette commande dans le terminal pour créer le projet Symfony avec tous les paquets de base.

### ` symfony new pecheur --full `

Avant de continuer il faut aller dans le fichier .env afin de rentrer notre connexion à la base de données en remplacant db_user, db_password et db_name par nos propres informations.

DATABASE_URL=mysql://__db_user__:__db_password__@127.0.0.1:3306/__db_name__?serverVersion=5.7

## 2 - Création des entités

Une fois le projet initié, nous avons créé les deux entités "Post" et "Commentaire" nécessaires pour notre api blog.
Nous avons utilisé la ligne de commande :
### `php bin/console make:entity`

Il y a une relation OneToMany entre l'entité Post et l'entité Commentaire (ce qui crée un attribut "post" dans l'entité Commentaire).

## 3 - Migrations des entités

Quand les attributs de chaque entité ont été renseigné il nous reste à faire la migration vers la base de données.

On commence par faire le fichier de migrations avec la ligne de commande:

### `php bin/console make:migration`

Une fois ce fichier créé il nous reste plus qu'a éxécuter cette migrations à l'aide de cette commande:

### `php bin/console doctrine:migrations:migrate`

## 4 - Installation de paquet Api Platform

On utilise composer pour installer Api Platform dans notre projet Symfony.

## `composer require api`

Symfony c'est directement à quel bundle on fait appelle avec cette commande.

## 5 - Configuration et réglages d'Api Platform

De base Api Platform renvoi du json+ld, mais dans notre cas il nous faut seulement du json. Pour ce faire on se rend dans le fichier "api_platform.yaml" ( config>api_platform.yaml ) en précisant le format que l'on souhaite:

```
api_platform:
    mapping:
      paths: ['%kernel.project_dir%/src/Entity']
    patch_formats:
        json: ['application/merge-patch+json']
    swagger:
        versions: [3]
    formats:
        json:
            mime_types:
                - application/json
        html:
            mime_types:
                - text/html
```

Quand le format est choisi on peut commencer à créer notre API. Avec Api Platform rien de plus simple, dans nos entités il suffit de rajouter un use:

`use ApiPlatform\Core\Annotation\ApiFilter;`

et de faire nos réglages selon ce que l'on souhaite avoir en ajoutant des annotations au dessus de nos Classes:

```
/**
 * @ORM\Entity(repositoryClass=CommentaireRepository::class)
 * @ApiResource(
 *      attributes={
 *          "order"={"createdAt":"DESC"}
 *      },
 *      normalizationContext={"groups"={"read:commentaire"}},
 *      collectionOperations={"get", "post"},
 *      itemOperations={"get"}
 * )
 * @ApiFilter(SearchFilter::class,
 *      properties={"post": "exact"}
 * )
 */
class Commentaire
{......
```

Le simple fait de rajouter l'annotation "@ApiResource()" crée l'API directement, dans les parenthèses ce sont les différents paramètres que l'on peut rajouter.
Dans notre exemple ci-dessus:
* `attributes={"order"={"createdAt":"DESC"}}` grâce à cette annotation on aura les derniers Post et/ou Commentaire qui seront affichés en premier.
* `normalizationContext={"groups"={"read:post"}}` nous permet de créer des groupes, et au dessus des attributs que l'on veut afficher on rajoute l'annotation `* @Groups({"read:commentaire"})`
* `collectionOperations={"get", "post"}` cette annotation nous permet de dire à Api Platform quelle méthode on souhaite utiliser, ici on veut que les méthodes GET et POST.
* `itemOperations={"get"}` ceci nous permet d'avoir une méthode GET pour un Commentaire en particulier en utilisant son {id}. C'est la même annotation pour la classe Post.
* `@ApiFilter(SearchFilter::class,properties={"post": "exact"})` à l'aide de ce filtre on affiche uniquement les commentaires reliés à un post.

## 6 - Réglages des CORS

En installant Api Platform, le bundle Nelmio Cors est installé également, ce qui nous permet d'éviter les erreurs CORS. Il y a quelques réglages à faire. On se rend dans le fichier config>nelmio_cors.yaml et on change " allow_origin " et allow_headers " :
```
nelmio_cors:
    defaults:
        origin_regex: true
        allow_origin: ['*']
        allow_methods: ['GET', 'OPTIONS', 'POST', 'PUT', 'PATCH', 'DELETE']
        allow_headers: ['*']
        expose_headers: ['Link']
        max_age: 3600
    paths:
        '^/': null
```

Dans le fichier .env il y a également une ligne qui a été rajouté automatiquement `CORS_ALLOW_ORIGIN=^https?://(localhost|127\.0\.0\.1)(:[0-9]+)?$`

Avec tous ces réglages l'API est fonctionnelle !
