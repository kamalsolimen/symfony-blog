<?php

namespace Blog\Bundle\CategoriesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Blog\Bundle\CategoriesBundle\Entity\Category;
use Blog\Bundle\CategoriesBundle\Form\CategoryForm;
use Symfony\Component\HttpFoundation\Session\Session;

class AdminController extends Controller
{
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $categories = $em->getRepository('BlogCategoriesBundle:Category')->findAll();

        return $this->render('BlogCategoriesBundle:Admin:list.html.twig' , ['categories'=>$categories] );
    }

    public function createAction(Request $request)
    {
        $category = new Category();
        $form = $this->createForm(new CategoryForm(), $category, array(
            'action'=>$this->generateUrl('BlogCategories_admin_create') ,
            'method'=>'POST'
        ));

        $form->handleRequest($request);
        if($request->isMethod('POST'))
        {
            if ($form->isValid())
            {
                $em = $this->getDoctrine()->getManager();

                $category->setSlug();

                $em->persist($category);
                $em->flush();

                $category->upload();

                $em->persist($category);
                $em->flush();

                $session = new Session();
                $session->getFlashBag()->add('sucess', 'Save Done');

                return $this->redirectToRoute('BlogCategories_admin_create');
            }
        }

        return $this->render('BlogCategoriesBundle:Admin:form.html.twig' , ["form" => $form->createView()] );
    }

    public function editAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $category = $em->getRepository('BlogCategoriesBundle:Category')->find($id);

        $form = $this->createForm(new CategoryForm(), $category, array(
            'action'=>$this->generateUrl('BlogCategories_admin_edit' , ['id'=>$id]) ,
            'method'=>'POST'
        ));

        $form->handleRequest($request);

        if($request->isMethod('POST'))
        {
            if ($form->isValid())
            {
                $category->setSlug();

                $em->persist($category);
                $em->flush();

                $category->upload();

                $em->persist($category);
                $em->flush();

                $session = new Session();
                $session->getFlashBag()->add('sucess', 'Save Done');

                return $this->redirectToRoute('BlogCategories_admin_list');
            }
        }

        return $this->render('BlogCategoriesBundle:Admin:form.html.twig' , ["form" => $form->createView() , 'category'=>$category] );
    }

    public function deleteAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        if($cat = $request->query->get('id'))
        {
            $category = $em->getRepository('BlogCategoriesBundle:Category')->find($cat);
            $em->remove($category);
            $em->flush();
        }
        else if($cats = $request->request->get('category'))
        {
            foreach($cats as $cat)
            {
                $categories = $em->getRepository('BlogCategoriesBundle:Category')->find($cat);

                $em->remove($categories);
                $em->flush();
            }
        }

        $session = new Session();
        $session->getFlashBag()->add('sucess', 'delete Done');

        return $this->redirectToRoute('BlogCategories_admin_list');
    }


}
