<?php

namespace App\Controller\Dashboard;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ImportController extends AbstractController
{
    /**
     * @Route("/dashboard/import", name="dashboard_import")
     */
    public function index()
    {
        return $this->render('dashboard/import/index.html.twig', [
            'controller_name' => 'ImportController',
        ]);
    }
}
