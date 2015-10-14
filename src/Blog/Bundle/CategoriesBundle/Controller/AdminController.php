<?php

namespace Blog\Bundle\CategoriesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;
use Blog\Bundle\CategoriesBundle\Entity\Category;



class AdminController extends Controller
{
    /**
     * @Template()
     */
    public function indexAction($name)
    {
        return array('name' => $name);
    }

    public function createAction()
    {
        return $this->render('BlogCategoriesBundle:Admin:create.html.twig');
    }

}
