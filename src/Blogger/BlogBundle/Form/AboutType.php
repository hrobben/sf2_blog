<?php

namespace Blogger\BlogBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class AboutType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('inhoud', 'textarea', array(
                'attr' => array(
                    'class' => 'tinymce',
                    'data-theme' => 'advanced' // Skip it if you want to use default theme
                )
            ))
        ;
    }

    public function getName()
    {
        return 'about';
    }
}
