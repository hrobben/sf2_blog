<?php

namespace Blogger\BlogBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class SettingType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('inhoud', 'textarea', array(
                'attr' => array('cols' => '60', 'rows' => '20')));
    }

    public function getName()
    {
        return 'setting';
    }
}
