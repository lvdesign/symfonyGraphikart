
# Site Mon agence (sympfony 4)

https://www.grafikart.fr/tutoriels/presentation-1064


Dans ce premier chapitre nous allons découvrir ensemble le projet que l'on va chercher à réaliser et on va découvrir comment installer et configurer Symfony 4.





------------------------------------------------------
## Installation

Tous les modules de symfony :
composer create-project symfony/website-skeleton MONPROJET 4.3.1


------------------------------------------------------
## Composer 
- non global:
php composer.phar init

- recharger Composer apres modif/ajout ds Composer
php composer.phar dump-autoload

- mise a jour
php composer.phar update


------------------------------------------------------
### Server

php -S localhost:8000 -d display_errors=1 -t public/


------------------------------------------------------
## BD  
- Nom : masuperagence

- php bin/console doctrine:database:create

    #### Creation de tables

    - php bin/console make:entity Property
    
    - php bin/console make:migration

pour update : 
    - php bin/console make:entity Property

user 
- php bin/console make:entity Property
- php bin/console make:migration
- php bin/console doctrine:migrations:migrate    
------------------------------------------------------
## Console pour commande action

- php bin/console

- php bin/console debug:container

- php bin/console server:run


- generer un Formulaire :  php bin/console make:form
PropertyType (quel type de Class )
Property (pour quelle Entity)
        


- php bin/console make:fixture
- php bin/console make:fixtures:load --append
  UserFixtures ds DataFixtures

- php bin/console make:fixture
PropertyFixture


- php bin/console make:entity
Option
ManyToMany avec Property
-> make migration 


php bin/console make:crud
Option  -> tags 


php bin/console doctrine:migrations:status

revenir en arriere
php bin/console doctrine:migrations:migrate numberavant


//https://symfony.com/doc/master/bundles/DoctrineMigrationsBundle/index.html
php bin/console doctrine:migrations:diff
php bin/console doctrine:migrations:execute --up 20191201194641

------------------------------------------------------
## composer ajouts

### Slug pour et activé ds Property.php
https://github.com/cocur/slugify 
"cocur/slugify": "^3.2",
composer require cocur/slugify

## Bundle  orm-fixtures --dev

## Faker pour fixtures
https://github.com/fzaninotto/Faker
php composer.phar require fzaninotto/faker --dev

## Pagination Bundle
https://github.com/KnpLabs/KnpPaginatorBundle
"knplabs/knp-paginator-bundle": "^3.0",

## Search Bien avec Options
-> properties
---> relation ManyToMany  (Tags)  options
et refact la base 



## Bundle image

- Uploader: 
https://github.com/dustin10/VichUploaderBundle
composer require vich/uploader-bundle

- LiipImagineBundle
The LiipImagineBundle package provides an image manipulation abstraction toolkit for Symfony-based projects
https://github.com/liip/LiipImagineBundle
composer require liip/imagine-bundle

-> Listener :: creation d'un ecouteur pour les images et gestion de cache manager

- Bundle Swift Mailer
test avec $ mailDev

- Webpack par Symfony
 NO----php composer.phar require symfony/webpack-encore-pack
 NO----php composer.phar remove symfony/webpack-encore-pack

 php composer.phar require encore
 yarn install

-lancement 
npm run dev-server

______________________________________________________
## JS 

- select2 : https://select2.org/
https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/css/select2.min.css




------------------------------------------------------
## Doc Symfony

- doc Route ds Component
https://symfony.com/doc/current/routing.html#creating-routes-as-annotations
par Annotation
@Route("/biens", name="property.index" )


-> Page :: route + controleur -> reponse + twig

## Twig theme reglage -> twig.yaml

--> Form :: https://symfony.com/doc/current/reference/forms/types/text.html

--> Form Validation :: @Assert/

## Doctrine doc
https://www.doctrine-project.org/projects/doctrine-orm/en/2.6/reference/association-mapping.html#association-mapping
propietaire  ownerside / mappedBy


- DQL action ds Doctrine pour listes requetes 
https://www.doctrine-project.org/projects/doctrine-orm/en/2.6/reference/query-builder.html#the-querybuilder
toto toto
## 