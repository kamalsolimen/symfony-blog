<?php
/**
 * Created by PhpStorm.
 * User: kamal
 * Date: 10/14/15
 * Time: 6:11 PM
 */

namespace Blog\Bundle\CategoriesBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use Blog\Bundle\CategoriesBundle\Entity\Category;
use Blog\Bundle\ArticlesBundle\Entity\Article;



class LoadCategoryData extends AbstractFixture
{
    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create();

        for($i=0;$i<10;$i++)
        {
            $name = $faker->sentence(3);

            $category = new Category();
            $category->setName($name);
            $category->setSlug();

            $manager->persist($category);
            $manager->flush();

            $this->setReference('articles-categories', $category);
        }
    }

    public function getOrder()
    {
        return 1;
    }
}