<?php
/**
 * Created by PhpStorm.
 * User: kamal
 * Date: 10/14/15
 * Time: 11:10 PM
 */

namespace Blog\Bundle\CategoriesBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class CategoryForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name' , 'text' , array('label'=>'Category name' , 'required'=>false))
            ->add('file' , 'file' , array('label'=>'Category Image' , 'required'=>false))
        ;
    }

    public function getName()
    {
        return 'category';
    }
}