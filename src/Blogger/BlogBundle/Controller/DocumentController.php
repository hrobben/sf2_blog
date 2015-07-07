<?php
// src/Blogger/BlogBundle/Controller/BlogController.php

namespace Blogger\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Blogger\BlogBundle\Entity\Document;
use Blogger\BlogBundle\Form\DocumentType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Document controller.
 */
class DocumentController extends Controller
{

    public function uploadAction(Request $request)
    {
        $document = new document();
        $form = $this->createForm(new DocumentType(), $document);

        //$request = $this->getRequest();  decrepiated in future version 3.0
        if ($request->getMethod() === 'POST') {
            // $form->bind($request);  decrepiated Near Future
            $form->handleRequest($request);

            if ($form->isValid()) {
                // compute a random name and try to guess the extension (more secure)
                $extension = $file->guessExtension();
                if (!$extension) {
                    // extension cannot be guessed
                    $extension = 'bin';
                }

                $form['name']->getData()->move($dir, rand(1, 99999) . '.' . $extension);

            }
        }
    }
}