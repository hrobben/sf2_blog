<?php
// src/Blogger/BlogBundle/Controller/BlogController.php

namespace Blogger\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Blogger\BlogBundle\Entity\Blog;
use Blogger\BlogBundle\Form\BlogType;
use Symfony\Component\HttpFoundation\Request;

/**
 * Blog controller.
 */
class BlogController extends Controller
{
    private $oldImage;
    /**
     * Show a blog entry
     */
    public function showAction($id, $slug)
    {
        $em = $this->getDoctrine()->getManager();

        $blog = $em->getRepository('BloggerBlogBundle:Blog')->find($id);

        if (!$blog) {
            throw $this->createNotFoundException('Unable to find Blog post.' . $id);
        }

        /*       return $this->render('BloggerBlogBundle:Blog:show.html.twig', array(
                   'blog' => $blog,
               ));*/

        $comments = $em->getRepository('BloggerBlogBundle:Comment')
            ->getCommentsForBlog($blog->getId());

        return $this->render('BloggerBlogBundle:Blog:show.html.twig', array(
            'blog' => $blog,
            'comments' => $comments
        ));
    }

    public function createAction(Request $request)
    {
        //$blog = $this->getBlog($blog_id);

        $blog = new blog();
        $form = $this->createForm(new BlogType(), $blog);
        $form->handleRequest($request);

        if ($form->isValid()) {
            //$blog->setImage('image.jpg');
            // $file stores the uploaded PDF file
            /** @var Symfony\Component\HttpFoundation\File\UploadedFile $file */
            $file = $blog->getImage();

            // Generate a unique name for the file before saving it
            $fileName = md5($blog_id).'.'.$file->guessExtension();

            // Move the file to the directory where brochures are stored
            $imagesDir = $this->container->getParameter('kernel.root_dir').'/../web/images';
            $file->move($imagesDir, $fileName);

            // Update the 'brochure' property to store the PDF file name
            // instead of its contents
            $blog->setImage($fileName);

            $em = $this->getDoctrine()
                ->getManager();
            $em->persist($blog);
            $em->flush();

            return $this->redirect($this->generateUrl('BloggerBlogBundle_blog_show', array(
                'id' => $blog->getId(),
                'slug' => $blog->getSlug()
            )));
        }

        return $this->render('BloggerBlogBundle:Blog:create.html.twig', array(
            'blog' => $blog,
            'form' => $form->createView()
        ));
    }

    public function removeFile($file)
    {
        $file_path = ''.$file;
        if(file_exists($file_path)) unlink($file_path);
    }

    public function editAction(Request $request, $blog_id)
    {
        $blog = $this->getBlog($blog_id);
        $this->oldImage = $blog->getImage();  // option to delete unlink file if edit is chosen.

        $form = $this->createForm(new BlogType(), $blog);
        $form->handleRequest($request);


        if ($form->isValid()) {
            if ($form->get('image')->getData() !== null) {
                $this->removeFile($this->oldImage);
                // $file stores the uploaded PDF file
                /** @var Symfony\Component\HttpFoundation\File\UploadedFile $file */
                $file = $blog->getImage();

                // Generate a unique name for the file before saving it
                $fileName = md5($blog_id) . '.' . $file->guessExtension();

                // Move the file to the directory where brochures are stored
                $imagesDir = $this->container->getParameter('kernel.root_dir') . '/../web/images';
                $file->move($imagesDir, $fileName);

                // Update the 'brochure' property to store the PDF file name
                // instead of its contents
                $blog->setImage($fileName);
            } else {
                $blog->setImage($this->oldImage);
            }

            $em = $this->getDoctrine()
                ->getManager();
            $em->persist($blog);
            $em->flush();

            return $this->redirect($this->generateUrl('BloggerBlogBundle_blog_show', array(
                    'id' => $blog->getId(),
                    'slug' => $blog->getSlug()
            )));
        }

        return $this->render('BloggerBlogBundle:Blog:edit.html.twig', array(
            'blog' => $blog,
            'form' => $form->createView()
        ));
    }

    protected function getBlog($blog_id)
    {
        $em = $this->getDoctrine()
            ->getManager();

        $blog = $em->getRepository('BloggerBlogBundle:Blog')->find($blog_id);

        if (!$blog) {
            throw $this->createNotFoundException('Unable to find Blog post.');
        }

        return $blog;
    }

}