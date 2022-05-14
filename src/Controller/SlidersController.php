<?php

namespace App\Controller;

use App\Entity\Sliders;
use App\Form\SlidersType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/sliders")
 */
class SlidersController extends AbstractController
{
    /**
     * @Route("/", name="sliders_index", methods={"GET"})
     */
    public function index(): Response
    {
        $sliders = $this->getDoctrine()
            ->getRepository(Sliders::class)
            ->findAll();

        return $this->render('sliders/index.html.twig', [
            'sliders' => $sliders,
        ]);
    }

}
