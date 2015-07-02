<?php
// src/Blogger/BlogBundle/DataFixtures/ORM/CommentFixtures.php

namespace Blogger\BlogBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Blogger\BlogBundle\Entity\User;
use Blogger\BlogBundle\Entity\Blog;

class UserFixtures extends AbstractFixture implements OrderedFixtureInterface, FixtureInterface, ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * {@inheritDoc}
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setUsername('admin');
        //$user->setSalt(md5(uniqid()));
        $encoder = $this->container
            ->get('security.encoder_factory')
            ->getEncoder($user)
        ;
        $user->setPassword($encoder->encodePassword('secret', $user->getSalt()));
        $user->setEmail('hrobben@robusoft.nl');
        $user->setIsActive(true);
        $manager->persist($user);


        $user = new User();
        $user->setUsername('henry');
        //$user->setSalt(md5(uniqid()));
        $encoder = $this->container
            ->get('security.encoder_factory')
            ->getEncoder($user)
        ;
        $user->setPassword($encoder->encodePassword('secret', $user->getSalt()));
        $user->setEmail('hrobben@robusoft.com');
        $user->setIsActive(true);
        $manager->persist($user);

        $manager->flush();
    }

    public function getOrder()
    {
        return 3;
    }
}