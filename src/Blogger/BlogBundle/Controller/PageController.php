<?php
// src/Blogger/BlogBundle/Controller/PageController.php

namespace Blogger\BlogBundle\Controller;

use Blogger\BlogBundle\Entity\About;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Blogger\BlogBundle\Entity\Enquiry;
use Blogger\BlogBundle\Entity\Abouts;
use Blogger\BlogBundle\Entity\User;
use Blogger\BlogBundle\Form\EnquiryType;
use Blogger\BlogBundle\Form\AboutType;
use Blogger\BlogBundle\Form\UserType;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

class PageController extends Controller
{
    public function indexAction()
    {
        $em = $this->getDoctrine()
            ->getEntityManager();

        $blogs = $em->getRepository('BloggerBlogBundle:Blog')
            ->getLatestBlogs();

        return $this->render('BloggerBlogBundle:Page:index.html.twig', array(
            'blogs' => $blogs
        ));
    }

    public function aboutAction(Request $request)
    {
        $path = $this->get('kernel')->getRootDir() . '/config/about.txt';
        $About = new Abouts();
        $About->setInhoud(file_get_contents($path));
        $form = $this->createForm(new AboutType(), $About);

        //$request = $this->getRequest();  decrepiated in future version 3.0
        if ($request->getMethod() === 'POST') {
            // $form->bind($request);  decrepiated Near Future
            $form->handleRequest($request);

            if ($form->isValid()) {
                // Perform some action, such as sending an email
                file_put_contents($path, $About->getInhoud());
                // Redirect - This is important to prevent users re-posting
                // the form if they refresh the page
            }
        }

        return $this->render('BloggerBlogBundle:Page:about.html.twig', array(
            'form' => $form->createView(),
            'textfile' => $About->getInhoud()
        ));
    }

    public function contactAction(Request $request)
    {
        $enquiry = new Enquiry();
        $form = $this->createForm(new EnquiryType(), $enquiry);

        //$request = $this->getRequest();  decrepiated in future version 3.0
        if ($request->getMethod() === 'POST') {
            // $form->bind($request);  decrepiated Near Future
            $form->handleRequest($request);

            if ($form->isValid()) {
                // Perform some action, such as sending an email
                $message = \Swift_Message::newInstance()
                    ->setSubject('Contact enquiry from symblog')
                    ->setFrom('hrobben@robusoft.com')
                    ->setTo($this->container->getParameter('blogger_blog.emails.contact_email'))
//                    ->setTo('email@email.com')
                    ->setBody($this->renderView('BloggerBlogBundle:Page:contactEmail.txt.twig', array('enquiry' => $enquiry)));
                $this->get('mailer')->send($message);

//                $this->get('session')->setFlash('blogger-notice', 'Your contact enquiry was successfully sent. Thank you!');
                $this->get('session')->getFlashBag()->add('blogger-notice', 'Your contact enquiry was successfully sent. Thank you!');

                // Redirect - This is important to prevent users re-posting
                // the form if they refresh the page
                return $this->redirect($this->generateUrl('BloggerBlogBundle_contact'));
            }
        }

        return $this->render('BloggerBlogBundle:Page:contact.html.twig', array(
            'form' => $form->createView()
        ));
    }

    public function sidebarAction()
    {
        $em = $this->getDoctrine()
            ->getEntityManager();

        $tags = $em->getRepository('BloggerBlogBundle:Blog')
            ->getTags();

        $tagWeights = $em->getRepository('BloggerBlogBundle:Blog')
            ->getTagWeights($tags);

        $commentLimit   = $this->container
            ->getParameter('blogger_blog.comments.latest_comment_limit');
        $latestComments = $em->getRepository('BloggerBlogBundle:Comment')
            ->getLatestComments($commentLimit);

        return $this->render('BloggerBlogBundle:Page:sidebar.html.twig', array(
            'latestComments'    => $latestComments,
            'tags'              => $tagWeights
        ));
    }

}