<?php
/**
 * Created by PhpStorm.
 * User: kamal
 * Date: 10/14/15
 * Time: 11:10 PM
 */

namespace Blog\Bundle\ArticlesBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class ArticleForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('categories', 'entity', array('label' => 'Categories',
                'class'         => 'Blog\Bundle\CategoriesBundle\Entity\Category',
                'multiple'      => true,
                'expanded'      => true,
                'query_builder' => function ($repository)
                {
                    return $repository->createQueryBuilder('c')->orderBy('c.name', 'ASC');
                },))
            ->add('title' , 'text' ,[
                'label'=>'Title'
            ])
            ->add('content','textarea',[
                'label'=>'Article Content'
            ])
            ->add('file' ,'file' , [
                'label' => 'Article Image',
                'required' => false
            ])
            ->add('is_active' , 'checkbox' ,[
                 'label' => 'Is published',
                  'required' => false
                ]
            )
        ;
    }

    public function getName()
    {
        return 'article';
    }
}