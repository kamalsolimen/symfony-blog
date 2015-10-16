<?php

namespace Blog\Bundle\CommentsBundle\Controller;

use Blog\Bundle\CommentsBundle\Entity\Comment;
use Blog\Bundle\CommentsBundle\Form\AddCommentForm;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

class DefaultController extends Controller
{
    public function formAction($article_id)
    {
        $form = $this->getForm($article_id);

        return $this->render('BlogCommentsBundle:Default:addComment.html.twig' , ['form'=>$form->createView()] );
    }

    public function createAction($article_id , Request $request)
    {

        $repository = $this->getDoctrine()->getRepository('BlogArticlesBundle:Article');

        $query = $repository->createQueryBuilder('a')
            ->where('a.isActive = 1')
            ->where('a.id = :id')
            ->setParameter('id' , $article_id)
            ->setMaxResults(1)
            ->getQuery();

        $article = $query->getOneOrNullResult();


        $comment = new Comment();
        $form = $this->getForm($article_id , $comment);
        $form->handleRequest($request);
        if($request->isMethod('POST'))
        {
            if ($form->isValid())
            {
                $em = $this->getDoctrine()->getManager();

                $comment->setArticle($article);
                $comment->setIsActive(1);
                $comment->setCreatedAt(new \DateTime('now'));

                $em->persist($comment);
                $em->flush();

                $session = new Session();
                $session->getFlashBag()->add('sucess', 'Save Done');

                return $this->redirect($this->generateUrl('BlogArticles_view',  ['slug' => $article->getSlug()]) . '#comments');
            }
        }
    }

    public function listAction($article_id)
    {
        $repository = $this->getDoctrine()->getRepository('BlogCommentsBundle:Comment');

        $query = $repository->createQueryBuilder('a')
            ->innerJoin('a.article' , 'art')
            ->where('a.isActive = 1')
            ->where('art.id = :id')
            ->setParameter('id' , $article_id)
            ->orderBy('a.createdAt' , 'DESC')
            ->getQuery();

        //  toArray() =>  \Doctrine\ORM\Query::HYDRATE_ARRAY
        $comments = $query->getResult();

        return $this->render('BlogCommentsBundle:Default:list.html.twig' , ['comments'=>$comments] );
    }

    protected function getForm($article_id , $comment = null)
    {
        return $this->createForm(new AddCommentForm() , $comment, array(
            'action'=>$this->generateUrl('BlogComments_Default_create' , ['article_id'=>$article_id] ) ,
            'method'=>'POST'
        ));
    }
}
