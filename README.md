blog
====

This is a simple blog written in Symfony 2

created on October 14, 2015, 3:04 am.

Installation Instructions
==============
```bash
//to clone project
git clone https://github.com/kamalsolimen/symfony-blog.git

//to install vendor
composer install

//to create db and table
php app/console doctrine:schema:create

// to load fixtures default data
php app/console doctrine:fixtures:load

```

external bundle

* doctrine-fixtures-bundle
* cocur/slugify
* twig/extensions


