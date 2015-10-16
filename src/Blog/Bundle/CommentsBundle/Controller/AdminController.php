<?php

namespace Blog\Bundle\CommentsBundle\Controller;

use Blog\Bundle\CommentsBundle\Form\BoCommentForm;
use Blog\Bundle\CommentsBundle\Form\CommentForm;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;


class AdminController extends Controller
{

    public function indexAction($id)
    {
        $repository = $this->getDoctrine()->getRepository('BlogCommentsBundle:Comment');

        $query = $repository->createQueryBuilder('a')
            ->where('a.article = :id')
            ->setParameter('id' , $id)
            ->orderBy('a.createdAt' , 'DESC')
            ->getQuery();

        $comments = $query->getResult();

        $article = $this->getDoctrine()->getRepository('BlogArticlesBundle:Article')->findOneBy( [ 'id'=>$id ] );

        return $this->render('BlogCommentsBundle:Admin:list.html.twig' , [ 'comments'=>$comments ,
        'article' => $article
        ] );
    }

    public function editAction($id , Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $comment = $em->getRepository('BlogCommentsBundle:Comment')->find( $id );

        $form = $this->createForm(new BoCommentForm() , $comment, array(
            'action'=>$this->generateUrl('BlogComments_admin_edit' , [ 'id' => $id ] ) ,
            'method'=>'POST'
        ));

        $form->handleRequest($request);
        if($request->isMethod('POST'))
        {
            if ($form->isValid())
            {
                $em = $this->getDoctrine()->getManager();

                $comment->setCreatedAt(new \DateTime('now'));

                $em->persist($comment);
                $em->flush();

                $session = new Session();
                $session->getFlashBag()->add('sucess', 'Save Done');

                return $this->redirect($this->generateUrl('BlogComments_Admin_list',  [
                        'id' => $comment->getArticle()->getId() ]) . '#comments'
                );
            }
        }

        return $this->render('BlogCommentsBundle:Admin:form.html.twig' , [ 'form' => $form->createView() ,
        'comment' => $comment
        ] );

    }

    public function deleteAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        if($comm = $request->query->get('id'))
        {
            $comment = $em->getRepository('BlogCommentsBundle:Comment')->find($comm);
            $article_id = $comment->getArticle()->getId();
            $em->remove($comment);
            $em->flush();
        }
        else if($comments = $request->request->get('comments'))
        {
            foreach($comments as $comm)
            {
                $comment = $em->getRepository('BlogCommentsBundle:Comment')->find($comm);
                $article_id = $comment->getArticle()->getId();
                $em->remove($comment);
                $em->flush();
            }
        }

        $session = new Session();
        $session->getFlashBag()->add('sucess', 'delete Done');

        return $this->redirectToRoute('BlogComments_Admin_list' , [ 'id' => $article_id ] );
    }



}
