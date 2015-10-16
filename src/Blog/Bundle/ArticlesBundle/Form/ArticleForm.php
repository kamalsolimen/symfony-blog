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
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('categories', 'entity', array('label' => 'Channels',
                'class'         => 'Blog\Bundle\CategoriesBundle\Entity\Category',
                'multiple'      => true,
                'expanded'      => true,
                'query_builder' => function ($repository)
                {
                    return $repository->createQueryBuilder('c')->orderBy('c.name', 'ASC');
                },))
            ->add('title')
            ->add('content')
            ->add('file')
            ->add('is_active' , 'checkbox')

        ;
    }

    public function getName()
    {
        return 'article';
    }
}