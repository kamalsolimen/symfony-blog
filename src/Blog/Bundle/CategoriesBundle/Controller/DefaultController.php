<?php

namespace Blog\Bundle\CategoriesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Blog\Bundle\CategoriesBundle\Entity\Category;



class DefaultController extends Controller
{
    public function listAction()
    {
        $repository = $this->getDoctrine()->getRepository('BlogCategoriesBundle:Category');
        $query = $repository->createQueryBuilder('a')
            ->orderBy('a.id', 'ASC')
            ->getQuery();

        $categories = $query->getResult();

        return $this->render('BlogCategoriesBundle:Default:list.html.twig' , ['categories'=>$categories] );
    }
}
