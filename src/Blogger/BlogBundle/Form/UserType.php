<?php
// src/Blogger/BlogBundle/Form/UserType.php

namespace Blogger\BlogBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('Username');
        $builder->add('Password', 'password');
    }

    public function getName()
    {
        return 'user';
    }
}