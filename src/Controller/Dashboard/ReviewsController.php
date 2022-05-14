<?php

namespace App\Controller\Dashboard;

use App\Entity\Reviews;
use App\Form\ReviewsType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/dashboard/reviews")
 */
class ReviewsController extends BaseController
{
    /**
     * @Route("/", name="dashboard_reviews_index", methods={"GET"})
     */
    public function index(): Response
    {
        $reviews = $this->getDoctrine()
            ->getRepository(Reviews::class)
            ->findAll();

        return $this->render('dashboard/reviews/index.html.twig', [
            'reviews' => $reviews, 'user'=>$this->user
        ]);
    }

    /**
     * @Route("/new", name="reviews_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $review = new Reviews();
        $form = $this->createForm(ReviewsType::class, $review);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($review);
            $entityManager->flush();

            return $this->redirectToRoute('dashboard_reviews_index');
        }

        return $this->render('dashboard/reviews/new.html.twig', [
            'review' => $review,
            'form' => $form->createView(),
            'user'=>$this->user
        ]);
    }

    /**
     * @Route("/{id}", name="dashboard_reviews_show", methods={"GET"})
     */
    public function show(Reviews $review): Response
    {
        return $this->render('dashboard/reviews/show.html.twig', [
            'review' => $review, 'user'=>$this->user
        ]);
    }

    /**
     * @Route("/{id}/edit", name="reviews_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Reviews $review): Response
    {
        $form = $this->createForm(ReviewsType::class, $review);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('dashboard_reviews_index', [
                'id' => $review->getId(),
            ]);
        }

        return $this->render('dashboard/reviews/edit.html.twig', [
            'review' => $review,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="reviews_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Reviews $review): Response
    {
        if ($this->isCsrfTokenValid('delete'.$review->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($review);
            $entityManager->flush();
        }

        return $this->redirectToRoute('dashboard_reviews_index');
    }
}
