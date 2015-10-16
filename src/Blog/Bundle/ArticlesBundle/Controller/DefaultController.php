<?php

namespace Blog\Bundle\ArticlesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Blog\Bundle\ArticlesBundle\Entity\Article;

class DefaultController extends Controller
{

    public function indexAction()
    {
        $repository = $this->getDoctrine()->getRepository('BlogArticlesBundle:Article');

        $query = $repository->createQueryBuilder('a')
            ->where('a.isActive = 1')
            ->setMaxResults(10)
            ->orderBy('a.createdAt', 'DESC')
            ->getQuery();

        $articles = $query->getResult();

        return $this->render('BlogArticlesBundle:Default:index.html.twig' , ['articles'=>$articles] );
    }

    public function categoryAction($slug)
    {
        $repository = $this->getDoctrine()->getRepository('BlogArticlesBundle:Article');

        $query = $repository->createQueryBuilder('a')
            ->where('a.isActive = 1')
            ->innerJoin('a.categories' , 'c')
            ->where('c.slug = :slug')
            ->setParameter('slug' , $slug)
            ->orderBy('a.createdAt', 'DESC')
            ->getQuery();

        $articles = $query->getResult();

        return $this->render('BlogArticlesBundle:Default:index.html.twig' , ['articles'=>$articles] );
    }

    public function viewAction($slug)
    {
        $repository = $this->getDoctrine()->getRepository('BlogArticlesBundle:Article');

        $query = $repository->createQueryBuilder('a')
            ->where('a.isActive = 1')
            ->where('a.slug = :slug')
            ->setParameter('slug' , $slug)
            ->setMaxResults(1)
            ->getQuery();

        $article = $query->getOneOrNullResult();


        return $this->render('BlogArticlesBundle:Default:view.html.twig' , ['article'=>$article ] );
    }
}
