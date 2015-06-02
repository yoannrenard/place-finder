PLACE-FINDER
============

Place-finder REST API

# Requirements

- [Composer](https://getcomposer.org/doc/00-intro.md#globally)

# How to install

- composer install

# How to test

## PHPUnit

    bin/phpunit -c app/

## Behat

    bin/behat

## Road map

- Return 201 Response when create
- Oauth
- Edit place
- Delete place
- gestion du format de la reponse dans le header
- pagination
- HATEOAS
- JSON-LD
- API qui retourne la liste des champs pour editer/créer une place
- versionning API
- refacto JMS_Serializer + return new Response
- do not return place if deleted
