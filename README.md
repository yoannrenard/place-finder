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

- Edit place (save the proposition up)
- gestion du format de la reponse dans le header
- pagination
- HATEOAS
- JSON-LD
- API qui retourne la liste des champs pour editer/créer une place
- versionning API
- refacto JMS_Serializer + return new Response
- do not return place if deleted
- use SerializationContext (http://jolicode.com/blog/how-to-implement-your-own-fields-inclusion-rules-with-jms-serializer)
- upgrade sf to 2.7 ;)
- move the SoftDeleterPlaceUpdater into the entity (this is domain)
- Oauth
- admin
- PlaceFilter with validation
