<?php

namespace App\Controller;
use App\Entity\Sliders;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/home", name="home")
     */
    public function index()
    {
        //$response = $this->forward('App\Controller\SlidersController::index');       
        //return $response;

        return $this->render('home/index.twig');        
    }
}
