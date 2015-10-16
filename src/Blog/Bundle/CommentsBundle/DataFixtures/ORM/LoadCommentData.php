<?php
/**
 * Created by PhpStorm.
 * User: kamal
 * Date: 10/14/15
 * Time: 6:11 PM
 */

namespace Blog\Bundle\CategoriesBundle\DataFixtures\ORM;

use Blog\Bundle\CommentsBundle\Entity\Comment;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;



class LoadCommentData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create();

        for($i=0;$i<10;$i++)
        {
            for($c=0;$c<10;$c++)
            {
                for($x=0;$x<10;$x++)
                {
                    $name = $faker->sentence(3);

                    $comment = new Comment();
                    $comment->setName($name);
                    $comment->setEmail($faker->email);
                    $comment->setComment($faker->sentence(150));
                    $comment->setCreatedAt(new \DateTime('now'));
                    $comment->setIsActive($faker->boolean());
                    $comment->setArticle($this->getReference('art_'.$i.$c));

                    $manager->persist($comment);
                    $manager->flush();
                }

            }

        }
    }

    public function getOrder()
    {
        return 4;
    }
}