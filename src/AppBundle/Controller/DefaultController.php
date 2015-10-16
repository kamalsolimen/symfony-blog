<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Blog\Bundle\CategoriesBundle\Entity\Category;
use Symfony\Component\Debug\Debug;

class DefaultController extends Controller
{
    /**
     * @Route("/ss", name="homepage")
     */
    public function indexAction(Request $request)
    {
        Debug::enable();

        echo 'dddd';

        $category = new Category();
        $category->setName('ddd');
        $category->setDescription('dd');
        //$category->setSlug('dd');

        $em = $this->getDoctrine()->getManager();
        $em->persist($category);

        echo 'ddd';
    }
}
