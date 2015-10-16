<?php
/**
 * Created by PhpStorm.
 * User: kamal
 * Date: 10/14/15
 * Time: 11:10 PM
 */

namespace Blog\Bundle\CommentsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddCommentForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('name')
            ->add('email' , 'email' )
            ->add('comment' , 'textarea')
        ;
    }

    public function getName()
    {
        return 'addComment';
    }
}