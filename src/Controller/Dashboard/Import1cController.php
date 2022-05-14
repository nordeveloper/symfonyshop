<?php

namespace App\Controller\Dashboard;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class Import1cController extends AbstractController
{
    /**
     * @Route("/dashboard/import1c", name="dashboard_import1c")
     */
    public function index()
    {
        return $this->render('dashboard/import1c/index.html.twig', [
            'controller_name' => 'Import1cController',
        ]);
    }
}
