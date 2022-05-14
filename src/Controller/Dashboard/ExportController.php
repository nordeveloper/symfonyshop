<?php

namespace App\Controller\Dashboard;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ExportController extends AbstractController
{
    /**
     * @Route("/dashboard/export", name="dashboard_export")
     */
    public function index()
    {
        return $this->render('dashboard/export/index.html.twig', [
            'controller_name' => 'ExportController',
        ]);
    }
}
