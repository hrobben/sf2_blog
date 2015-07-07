<?php

namespace Blogger\BlogBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class BlogType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            //->add('slug')
            ->add('title')
            ->add('author')
            ->add('blog', 'ckeditor', array(
                'config' => array(

                    'toolbar' => array(
                        array(
                            'name'  => 'document',
                            'items' => array('Source', '-', 'Save', 'NewPage', 'DocProps', 'Preview', 'Print', '-', 'Templates', 'Image'),
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
            //->add('image')
            ->add('tags')
            //->add('created')
            //->add('updated')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Blogger\BlogBundle\Entity\Blog'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'blogger_blogbundle_blog';
    }
}
