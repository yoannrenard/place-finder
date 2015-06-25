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

- Get Places with parameters handler (default/valid/...)
- PlaceUpdateProposal operation validator
- PlaceUpdateProposal status validator
- gestion du format de la reponse dans le header
- HATEOAS - JSON-LD
- API qui retourne la liste des champs pour editer/créer une place
- versionning API
- refacto JMS_Serializer + return new Response
- Oauth
- admin
- PlaceFilter with validation
- move PlaceManager->getAllFiltered() into repository
- use cnotroller as a service
+ move the SoftDeleterPlaceUpdater into the entity (this is domain)
+ use SerializationContext (http://jolicode.com/blog/how-to-implement-your-own-fields-inclusion-rules-with-jms-serializer)
+ Edit place (save the proposition up)
+ remove PlaceFinder root dir
+ remove yoannrenard/...
+ pagination
