blog
====

A Symfony project created on October 14, 2015, 3:04 am.

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
virtual host
============
#/etc/apache2/sites-available

<VirtualHost *:80>
        ServerName {}
	    ServerAlias blog.dev.loc
        ServerAdmin admin@webmaster.com
        DocumentRoot {project_path}
</VirtualHost>

hosts
=====
# /etc/hosts

127.0.1.2	blog.dev.loc



