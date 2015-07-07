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
            ->add('inhoud', 'ckeditor', array(
                'config' => array(

                    'toolbar' => array(
                        array(
                            'name'  => 'document',
                            'items' => array('Source', '-', 'Save', 'NewPage', 'DocProps', 'Preview', 'Print', '-', 'Templates'),
                        ),
                        '/',
                        array(
                            'name'  => 'basicstyles',
                            'items' => array('Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'RemoveFormat'),
                        ),
                    ),
                    'uiColor' => '#ffffff',
                    //...
                ),
            ))
        ;
    }

    public function getName()
    {
        return 'about';
    }
}
