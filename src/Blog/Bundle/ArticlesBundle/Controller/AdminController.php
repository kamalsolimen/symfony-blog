<?php

namespace Blog\Bundle\ArticlesBundle\Controller;

use Blog\Bundle\ArticlesBundle\Entity\Article;
use Blog\Bundle\ArticlesBundle\Form\ArticleForm;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

class AdminController extends Controller
{
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $articles = $em->getRepository('BlogArticlesBundle:Article')->findAll();

        return $this->render('BlogArticlesBundle:Admin:list.html.twig' , ['articles'=>$articles] );
    }

    public function createAction(Request $request)
    {
        $article = new Article();

        $form = $this->createForm( new ArticleForm() , $article, array(
            'action'=>$this->generateUrl('BlogArticles_admin_create') ,
            'method'=>'POST'
        ));

        return $this->saveProcess($article , $form, $request);
    }

    public function editAction($id , Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $article = $em->getRepository('BlogArticlesBundle:Article')->find($id);

        if (!$article)
        {
            throw $this->createNotFoundException('Unable to find Article.');
        }

        $form = $this->createForm( new ArticleForm() , $article, array(
            'action'=>$this->generateUrl('BlogArticles_admin_edit' , ['id'=>$id]) ,
            'method'=>'POST'
        ));

        return $this->saveProcess($article , $form , $request);
    }

    public function deleteAction(Request $request)
    {
        if($item = $request->query->get('id'))
        {
            $this->deleteArticle($item);
        }
        else if($articles = $request->request->get('article'))
        {
            foreach($articles as $item)
            {
                $this->deleteProcess($item);
            }
        }

        $session = new Session();
        $session->getFlashBag()->add('sucess', 'delete Done');

        return $this->redirectToRoute('BlogArticles_admin_list');
    }

    protected function deleteProcess($id)
    {
        $em = $this->getDoctrine()->getManager();

        $article = $em->getRepository('BlogArticlesBundle:Article')->find($id);

        $em->remove($article);
        $em->flush();
    }

    protected function saveProcess($article , $form , $request)
    {
        $form->handleRequest($request);
        if($request->isMethod('POST'))
        {
            if ($form->isValid())
            {
                $em = $this->getDoctrine()->getManager();

                $article->setSlug();
                $article->setCreatedAt(new \DateTime('now'));

                $em->persist($article);
                $em->flush();

                $article->upload();

                $em->persist($article);
                $em->flush();

                $session = new Session();
                $session->getFlashBag()->add('sucess', 'Save Done');

                return $this->redirectToRoute('BlogArticles_admin_list');
            }
        }

        return $this->render('BlogArticlesBundle:Admin:form.html.twig' , ["form" => $form->createView()] );
    }
}
