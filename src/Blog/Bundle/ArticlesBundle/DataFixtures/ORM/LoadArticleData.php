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
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Blog\Bundle\ArticlesBundle\Entity\Article;


class LoadArticleData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create();

        for($i=0;$i<10;$i++)
        {
            for($r=0;$r<10;$r++)
            {
                $title = $faker->sentence(3);
                $images = ['faker-1.jpg','faker-3.jpg','faker-3.jpg'];

                $article = new Article();
                $article->setTitle($title);
                $article->setSlug();
                $article->setContent($faker->realText());
                $article->setIsActive(1);
                $article->setImage($images[rand(0,2)]);


                $article->addCategory( $this->getReference('cat_'.$i) );

                $article->setCreatedAt(new \DateTime('now'));

                $manager->persist($article);
                $manager->flush();

                $this->addReference('art_'.$i.$r, $article);
            }
        }
    }


    public function getOrder()
    {
        return 3;
    }
}