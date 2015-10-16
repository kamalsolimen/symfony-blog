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
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

class LoadCategoryData extends AbstractFixture implements OrderedFixtureInterface
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

            $this->addReference('cat_'.$i, $category);

        }
    }

    public function getOrder()
    {
        return 2;
    }
}