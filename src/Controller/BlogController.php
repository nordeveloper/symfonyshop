<?php

namespace App\Controller;

use App\Entity\Blog;
use App\Form\BlogType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/blog")
 */
class BlogController extends AbstractController
{
    /**
     * @Route("/", name="blog_index", methods={"GET"})
     */
    public function index(): Response
    {
        $results = $this->getDoctrine()
            ->getRepository(Blog::class)
            ->findAll();

        return $this->render('articles/index.html.twig', [
            'results' => $results,
        ]);
    }

    /**
     * @Route("/{id}", name="blog_show", methods={"GET"})
     */
    public function show(Blog $article): Response
    {
        return $this->render('articles/show.html.twig', [
            'result' =>$article,
        ]);
    }

}
