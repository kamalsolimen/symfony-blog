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
use Blog\Bundle\CategoriesBundle\Entity\Category;



class LoadArticleData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create();

        for($i=0;$i<10;$i++)
        {
            $title = $faker->sentence(3);
            $images = ['faker-1.jpg','faker-3.jpg','faker-3.jpg'];

            $article = new Article();
            $article->setTitle($title);
            $article->setSlug();
            $article->setContent($faker->realText());
            $article->setIsActive(1);
            $article->setImage($images[rand(0,2)]);

            //$article->setCategories( $this->getReference('articles-categories') );
            //$article->getCategories()->add($this->getCategories($manager));

            $article->setCreatedAt(new \DateTime('now'));

            $manager->persist($article);
            $manager->flush();
        }
    }

    protected function getCategories($manager)
    {

        $cats = $manager->getRepository('BlogCategoriesBundle:Category')->findAll();
        foreach($cats as $cat)
            $ids[] = $cat->getId();

        return $ids;

    }

    public function getOrder()
    {
        return 2;
    }
}