<?php
/**
 * Created by PhpStorm.
 * User: kamal
 * Date: 10/14/15
 * Time: 6:11 PM
 */

namespace Blog\Bundle\CategoriesBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Blog\Bundle\CategoriesBundle\Entity\Category;



class LoadCategoryData implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create();

        for($i=0;$i<50;$i++)
        {
            $name = $faker->sentence(3);

            $category = new Category();
            $category->setName($name);
            $category->setDescription($faker->text());
            $category->setSlug($name);

            $manager->persist($category);
            $manager->flush();
        }
    }
}